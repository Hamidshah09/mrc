<?php

namespace App\Http\Controllers;

use App\Models\DivorceCase;
use App\Models\DivorceHearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DivorceCaseController extends Controller
{
    public function index(Request $request)
    {
        $query = DivorceCase::with('hearings')->latest();

        if ($request->filled('search') && $request->filled('search_type')) {
            $searchType = $request->input('search_type');
            $searchValue = $request->input('search');

            if (in_array($searchType, ['case_no', 'groom_cnic', 'groom_name', 'bride_cnic', 'bride_name'])) {
                $query->where($searchType, 'LIKE', '%' . $searchValue . '%');
            }
        }

        if ($request->filled('divorce_type')) {
            $query->where('divorce_type', $request->input('divorce_type'));
        }

        if ($request->filled('entry_type')) {
            $query->where('entry_type', $request->input('entry_type'));
        }

        if ($request->filled('from')) {
            $query->whereDate('decision_date', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('decision_date', '<=', $request->input('to'));
        }

        $divorceCases = $query->paginate(10)->withQueryString();

        return view('drc.index', compact('divorceCases'));
    }

    public function create()
    {
        return redirect()->route('drc.live.create');
    }

    public function createLive()
    {
        $divorceCase = new DivorceCase([
            'entry_type' => 'live',
            'applicant_side' => 'groom',
        ]);

        return view('drc.create-live', compact('divorceCase'));
    }

    public function createOld()
    {
        $divorceCase = new DivorceCase([
            'entry_type' => 'old',
            'applicant_side' => 'groom',
        ]);

        return view('drc.create-old', compact('divorceCase'));
    }

    public function storeLive(Request $request)
    {
        $validated = $this->validatedLiveCaseData($request);
        $validated['created_by'] = Auth::id();
        $validated['entry_type'] = 'live';

        $divorceCase = DivorceCase::create($validated);
        $this->createFirstLiveNotice($divorceCase, $request->date('notice_date'), $request->date('hearing_date'));

        return redirect()
            ->route('drc.show', $divorceCase)
            ->with('success', 'Live divorce registration case created successfully.');
    }

    public function storeOld(Request $request)
    {
        $validated = $this->validatedOldCaseData($request);
        $validated['created_by'] = Auth::id();
        $validated['entry_type'] = 'old';

        $divorceCase = DivorceCase::create($validated);
        $this->createCompletedOldNoticeSchedule($divorceCase);

        return redirect()
            ->route('drc.show', $divorceCase)
            ->with('success', 'Old completed divorce case saved successfully.');
    }

    public function show(DivorceCase $divorceCase)
    {
        $divorceCase->load('hearings');

        return view('drc.show', compact('divorceCase'));
    }

    public function edit(DivorceCase $divorceCase)
    {
        return view('drc.edit', compact('divorceCase'));
    }

    public function update(Request $request, DivorceCase $divorceCase)
    {
        $validated = $divorceCase->entry_type === 'old'
            ? $this->validatedOldCaseData($request, $divorceCase)
            : $this->validatedLiveCaseData($request, $divorceCase);

        $divorceCase->update($validated);

        if ($divorceCase->entry_type === 'old') {
            $this->syncCompletedOldNoticeSchedule($divorceCase);
        }

        return redirect()
            ->route('drc.show', $divorceCase)
            ->with('success', 'Divorce registration case updated successfully.');
    }

    public function updateHearing(Request $request, DivorceCase $divorceCase, DivorceHearing $hearing)
    {
        return $this->completeHearing($request, $divorceCase, $hearing);
    }

    public function completeHearing(Request $request, DivorceCase $divorceCase, DivorceHearing $hearing)
    {
        abort_unless($hearing->divorce_case_id === $divorceCase->id, 404);

        if ($hearing->isCompleted()) {
            return redirect()
                ->route('drc.show', $divorceCase)
                ->withErrors(['hearing' => 'This notice proceeding is already completed and cannot be updated.']);
        }

        $validated = $request->validate([
            'hearing_date' => ['required', 'date', 'after_or_equal:notice_date'],
            'remarks' => ['required', 'string', 'max:1000'],
            'proceeding' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        if ($hearing->proceeding_path && Storage::disk('public')->exists($hearing->proceeding_path)) {
            Storage::disk('public')->delete($hearing->proceeding_path);
        }

        $hearing->update([
            'hearing_date' => $validated['hearing_date'],
            'status' => 'heard',
            'next_hearing_date' => null,
            'remarks' => $validated['remarks'],
            'proceeding_path' => $request->file('proceeding')->store('drc_proceedings', 'public'),
        ]);

        if ($hearing->notice_number < 3) {
            $this->createNextNoticeIfMissing($divorceCase, $hearing);
        }

        if ($hearing->notice_number === 3) {
            $divorceCase->update([
                'decision_date' => $hearing->hearing_date,
            ]);
        }

        return redirect()
            ->route('drc.show', $divorceCase)
            ->with('success', 'Proceeding completed successfully.');
    }

    public function postponeHearing(Request $request, DivorceCase $divorceCase, DivorceHearing $hearing)
    {
        abort_unless($hearing->divorce_case_id === $divorceCase->id, 404);

        if ($hearing->isCompleted()) {
            return redirect()
                ->route('drc.show', $divorceCase)
                ->withErrors(['hearing' => 'This notice proceeding is already completed and cannot be postponed.']);
        }

        $validated = $request->validate([
            'notice_date' => ['required', 'date'],
            'hearing_date' => ['required', 'date', 'after_or_equal:notice_date'],
            'next_hearing_date' => ['required', 'date', 'after_or_equal:hearing_date'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $hearing->update([
            'notice_date' => $validated['notice_date'],
            'hearing_date' => $validated['hearing_date'],
            'status' => 'postponed',
            'next_hearing_date' => $validated['next_hearing_date'],
            'remarks' => $validated['remarks'] ?? $hearing->remarks,
        ]);

        return redirect()
            ->route('drc.show', $divorceCase)
            ->with('success', 'Next hearing date saved successfully.');
    }

    public function notice(DivorceCase $divorceCase, DivorceHearing $hearing)
    {
        abort_unless($hearing->divorce_case_id === $divorceCase->id, 404);

        return view('drc.notice', compact('divorceCase', 'hearing'));
    }

    public function certificate(DivorceCase $divorceCase)
    {
        $divorceCase->load('hearings');

        abort_unless($divorceCase->allHearingsCompleted(), 403);

        if (!$divorceCase->decision_date) {
            $thirdHearing = $divorceCase->hearings->firstWhere('notice_number', 3);

            if ($thirdHearing) {
                $divorceCase->decision_date = $thirdHearing->hearing_date;
            }
        }

        if (!$divorceCase->issue_date) {
            $divorceCase->issue_date = now()->toDateString();
        }

        if ($divorceCase->isDirty(['decision_date', 'issue_date'])) {
            $divorceCase->save();
        }

        return view('drc.certificate', compact('divorceCase'));
    }

    private function validatedCommonCaseData(Request $request, ?DivorceCase $divorceCase = null): array
    {
        return $request->validate([
            'case_no' => [
                'required',
                'string',
                'max:50',
                Rule::unique('divorce_cases', 'case_no')->ignore($divorceCase?->id),
            ],
            'divorce_type' => ['required', Rule::in(['Talaq', 'Khula', 'Talaq Tafveez'])],
            'applicant_side' => ['required', Rule::in(['groom', 'bride'])],
            'groom_cnic' => ['required', 'digits:13'],
            'groom_name' => ['required', 'string', 'max:100'],
            'groom_father_name' => ['required', 'string', 'max:100'],
            'groom_address' => ['required', 'string', 'max:500'],
            'bride_cnic' => ['required', 'digits:13'],
            'bride_name' => ['required', 'string', 'max:100'],
            'bride_father_name' => ['required', 'string', 'max:100'],
            'bride_address' => ['required', 'string', 'max:500'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function validatedLiveCaseData(Request $request, ?DivorceCase $divorceCase = null): array
    {
        $validated = $this->validatedCommonCaseData($request, $divorceCase);

        if (!$divorceCase || !$divorceCase->exists) {
            $request->validate([
                'notice_date' => ['required', 'date'],
                'hearing_date' => ['required', 'date', 'after_or_equal:notice_date'],
            ]);
        }

        return $validated;
    }

    private function validatedOldCaseData(Request $request, ?DivorceCase $divorceCase = null): array
    {
        $validated = array_merge($this->validatedCommonCaseData($request, $divorceCase), $request->validate([
            'decision_date' => ['required', 'date'],
            'issue_date' => ['required', 'date', 'after_or_equal:decision_date'],
        ]));

        return $validated;
    }

    private function createFirstLiveNotice(DivorceCase $divorceCase, Carbon $noticeDate, Carbon $hearingDate): void
    {
        $divorceCase->hearings()->create([
            'notice_number' => 1,
            'notice_date' => $noticeDate,
            'hearing_date' => $hearingDate,
            'status' => 'scheduled',
        ]);
    }

    private function createCompletedOldNoticeSchedule(DivorceCase $divorceCase): void
    {
        $this->syncCompletedOldNoticeSchedule($divorceCase);
    }

    private function syncCompletedOldNoticeSchedule(DivorceCase $divorceCase): void
    {
        foreach ([1 => -60, 2 => -30, 3 => 0] as $noticeNumber => $days) {
            $hearingDate = $divorceCase->decision_date->copy()->addDays($days);

            $divorceCase->hearings()->updateOrCreate([
                'notice_number' => $noticeNumber,
            ], [
                'notice_number' => $noticeNumber,
                'notice_date' => $hearingDate,
                'hearing_date' => $hearingDate,
                'status' => 'heard',
            ]);
        }
    }

    private function createNextNoticeIfMissing(DivorceCase $divorceCase, DivorceHearing $completedHearing): void
    {
        $nextNoticeNumber = $completedHearing->notice_number + 1;

        if ($divorceCase->hearings()->where('notice_number', $nextNoticeNumber)->exists()) {
            return;
        }

        $nextDate = $completedHearing->hearing_date->copy()->addDays(30);

        $divorceCase->hearings()->create([
            'notice_number' => $nextNoticeNumber,
            'notice_date' => $nextDate,
            'hearing_date' => $nextDate,
            'status' => 'scheduled',
        ]);
    }
}
