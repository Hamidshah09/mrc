<x-app-layout>
    @php
        if ($divorceCase->arbitrationType->id > 0 and $divorceCase->arbitrationType->id < 5){
            $canIssueCertificate = $divorceCase->allHearingsCompleted();    
        }else{
            $canIssueCertificate = false;
        }

        
        
        $completedNoticesCount = $divorceCase->hearings->filter(function($h){ return method_exists($h,'isCompleted') ? $h->isCompleted() : false; })->count();

        // Decision Date classes
        $decisionHasDate = (bool) $divorceCase->decision_date;
        $decisionOuterClass = $decisionHasDate ? 'p-4 bg-green-50 rounded-lg flex items-start gap-3' : 'p-4 bg-yellow-50 rounded-lg flex items-start gap-3';
        $decisionTextClass = $decisionHasDate ? 'font-medium text-green-800' : 'font-medium text-yellow-800';

        // Issue Date classes
        $issueHasDate = (bool) $divorceCase->issue_date;
        $issueOuterClass = $issueHasDate ? 'p-4 bg-green-50 rounded-lg flex items-start gap-3' : 'p-4 bg-yellow-50 rounded-lg flex items-start gap-3';
        $issueTextClass = $issueHasDate ? 'font-medium text-green-800' : 'font-medium text-yellow-800';

        // Status badge classes based on completed notices
        if ($completedNoticesCount <= 0) {
            $statusBadgeClass = 'bg-yellow-100 text-yellow-800';
        } elseif ($completedNoticesCount === 1) {
            $statusBadgeClass = 'bg-orange-100 text-orange-800';
        } elseif ($completedNoticesCount === 2) {
            $statusBadgeClass = 'bg-green-100 text-green-800';
        } else {
            $statusBadgeClass = 'bg-green-800 text-white';
        }
    @endphp
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-7 h-7 text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor" />
                </svg>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Arbitraion Details') }}</h2>
                    <p class="text-sm text-gray-500">Case overview and recent proceedings</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('drc.index') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-50">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>


    <div class="w-[95%] mx-auto space-y-6 mt-10" style="background:#f0fbf6;">
        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-700 rounded border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="bg-white shadow-md rounded-xl p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-indigo-50 rounded-full flex items-center justify-center">
                        <x-heroicon-o-bookmark class="w-6 h-6"/>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Case No: {{ $divorceCase->case_no }}</h3>
                        <p class="text-sm text-gray-500">{{ $divorceCase->divorce_type }} • {{ ucfirst($divorceCase->entry_type) }} entry • Arbitraion Type: {{$divorceCase->arbitrationType->type}} • Applicant: {{ ucfirst($divorceCase->applicant_side) }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="inline-flex items-center gap-2 text-sm px-2.5 py-1 rounded-full {{ $statusBadgeClass }}">
                                
                                {{ \Illuminate\Support\Str::title($divorceCase->status->status) }}
                            </span>
                            <span class="text-sm text-gray-400">Decision: {{ optional($divorceCase->decision_date)->format('d-m-Y') ?? 'Pending' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if ($canIssueCertificate)
                        <a href="{{ route('drc.certificate', $divorceCase) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">
                            <x-heroicon-o-document-check class="w-5 h-5"/>

                            Issue Certificate
                        </a>
                    @endif
                    <a href="{{ route('drc.edit', $divorceCase) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-indigo-600 text-indigo-600 hover:bg-indigo-50">
                        <x-heroicon-o-pencil class="w-5 h-5"/>
                        Edit Case
                    </a>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="{{ $decisionOuterClass }}">
                    <div class="p-2 bg-white rounded shadow-sm">
                        <x-heroicon-o-document-check class="w-5 h-5 text-indigo-600"/>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Decision Date</div>
                        <div class="{{ $decisionTextClass }}">{{ optional($divorceCase->decision_date)->format('d-m-Y') ?? 'Pending' }}</div>
                    </div>
                </div>
                <div class="{{ $issueOuterClass }}">
                    <div class="p-2 bg-white rounded shadow-sm">
                        <svg class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8v4l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Date of Issue</div>
                        <div class="{{ $issueTextClass }}">{{ optional($divorceCase->issue_date)->format('d-m-Y') ?? 'Pending' }}</div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg flex items-start gap-3">
                    <div class="p-2 bg-white rounded shadow-sm">
                        <svg class="w-5 h-5 text-yellow-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Status</div>
                        <div class="font-medium text-gray-800">{{ \Illuminate\Support\Str::title($divorceCase->status->status) }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg border border-gray-100 p-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold text-gray-800">Groom</h4>
                        <div class="text-sm text-gray-500">Details</div>
                    </div>
                    <div class="mt-3 space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between"><div class="text-gray-500">Name</div><div>{{ $divorceCase->groom_name }}</div></div>
                        <div class="flex justify-between"><div class="text-gray-500">Father Name</div><div>{{ $divorceCase->groom_father_name }}</div></div>
                        <div class="flex justify-between"><div class="text-gray-500">CNIC</div><div>{{ $divorceCase->groom_cnic }}</div></div>
                        <div class="flex justify-between"><div class="text-gray-500">Address</div><div class="text-right max-w-xs">{{ $divorceCase->groom_address }}</div></div>
                    </div>
                </div>
                <div class="bg-white rounded-lg border border-gray-100 p-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold text-gray-800">Bride</h4>
                        <div class="text-sm text-gray-500">Details</div>
                    </div>
                    <div class="mt-3 space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between"><div class="text-gray-500">Name</div><div>{{ $divorceCase->bride_name }}</div></div>
                        <div class="flex justify-between"><div class="text-gray-500">Father Name</div><div>{{ $divorceCase->bride_father_name }}</div></div>
                        <div class="flex justify-between"><div class="text-gray-500">CNIC</div><div>{{ $divorceCase->bride_cnic }}</div></div>
                        <div class="flex justify-between"><div class="text-gray-500">Address</div><div class="text-right max-w-xs">{{ $divorceCase->bride_address }}</div></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white shadow-md rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notices and Proceedings</h3>

            <div class="space-y-4">
                @foreach ($divorceCase->hearings as $hearing)
                    <div x-data="{ openPostpone: false }" @keydown.window.escape="openPostpone = false" class="rounded-lg overflow-hidden border shadow-sm p-4" style="background: rgba(255,255,255,0.18); backdrop-filter: blur(6px); border:1px solid rgba(255,255,255,0.25);">
                        <div class="px-4 py-3 text-white flex items-center justify-between rounded-t-lg" style="background: linear-gradient(90deg,#1a63e0 0%,#3d6dc0 100%);">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded flex items-center justify-center">
                                    @if (!$hearing->isCompleted())
                                        <x-ionicon-time-outline class="text-white w-6 h-6" />
                                    @else
                                        <x-heroicon-s-check class="text-white w-6 h-6" />
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Notice {{ $hearing->notice_number }}</h4>
                                    <p class="text-sm opacity-90">Notice: {{ optional($hearing->notice_date)->format('d-m-Y') }} • Hearing: {{ optional($hearing->effective_hearing_date)->format('d-m-Y') }}</p>
                                </div>
                            </div>
                            <div><!-- actions area left empty in header; buttons are shown below --></div>
                        </div>

                        @if ($hearing->isCompleted())
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <div class="text-xs uppercase text-gray-500">Status</div>
                                    <div class="font-semibold text-green-700">Completed</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase text-gray-500">Notice Date</div>
                                    <div>{{ optional($hearing->notice_date)->format('d-m-Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase text-gray-500">Hearing Date</div>
                                    <div>{{ optional($hearing->hearing_date)->format('d-m-Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs uppercase text-gray-500">Document</div>
                                    @if ($hearing->proceeding_path)
                                        <a href="{{ asset('storage/' . $hearing->proceeding_path) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                            <x-heroicon-o-document-check class="w-5 h-5"/>
                                            View proceeding
                                        </a>
                                    @else
                                        <span class="text-gray-500">No document uploaded</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="text-xs uppercase text-gray-500">Remarks</div>
                                <p class="text-sm text-gray-800">{{ $hearing->remarks ?: 'No remarks recorded.' }}</p>
                            </div>
                        @else
                            <div class="mt-4">
                                <div class="rounded-lg overflow-hidden border shadow-sm">
                                    <div class="p-4">
                                        <form action="{{ route('drc.hearings.complete', [$divorceCase, $hearing]) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600">Hearing Date</label>
                                                    <input type="date" name="hearing_date" class="mt-1 w-full rounded-md border-gray-200 shadow-sm focus:ring-2 focus:ring-[#154fb2]/40" value="{{ old('hearing_date', optional($hearing->effective_hearing_date)->format('Y-m-d')) }}" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600">Proceeding Document</label>
                                                    <input type="file" name="proceeding" class="mt-1 w-full rounded-md border-gray-200 shadow-sm" required>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600">Proceeding Remarks</label>
                                                <textarea name="remarks" rows="2" class="mt-1 w-full rounded-md border-gray-200 shadow-sm" required>{{ old('remarks') }}</textarea>
                                            </div>
                                            <div>
                                                
                                                <div class="flex items-center gap-2">
                                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-white" style="background:#154fb2;" onmouseover="this.style.background='#133f8e'" onmouseout="this.style.background='#154fb2'">
                                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        Mark Completed
                                                    </button>
                                                    @if (!$hearing->isCompleted())
                                                        <a href="{{ route('drc.notice', [$divorceCase, $hearing]) }}" target="_blank" class="bg-indigo-500 inline-flex items-center gap-2 px-3 py-2 rounded-md text-white hover:bg-indigo-700">
                                                            <x-ionicon-print-outline class="text-white-300 w-6 h-6" />
                                                            Print Notice
                                                        </a>

                                                        <button type="button" @click="openPostpone = true" class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-yellow-500 text-white hover:bg-yellow-600">
                                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                            Postpone Hearing
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Postpone Modal (Alpine.js) -->
                                <div x-show="openPostpone" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4">
                                    <div class="absolute inset-0 bg-black/50" @click="openPostpone = false"></div>
                                    <div @click.stop class="relative w-full max-w-2xl bg-white rounded-lg shadow-lg overflow-hidden">
                                        <div class="flex items-center justify-between px-4 py-3 border-b">
                                            <h3 class="text-lg font-semibold">Postpone Hearing</h3>
                                            <button type="button" class="text-gray-500 hover:text-gray-700" @click="openPostpone = false">&times;</button>
                                        </div>
                                        <div class="p-4">
                                            <form action="{{ route('drc.hearings.postpone', [$divorceCase, $hearing]) }}" method="POST" class="space-y-3">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600">Notice Date</label>
                                                        <input type="date" name="notice_date" class="mt-1 w-full rounded-md border-gray-200 shadow-sm focus:ring-2 focus:ring-[#37b6ad]/40" value="{{ old('notice_date', optional($hearing->notice_date)->format('Y-m-d')) }}" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600">Hearing Date</label>
                                                        <input type="date" name="hearing_date" class="mt-1 w-full rounded-md border-gray-200 shadow-sm focus:ring-2 focus:ring-[#37b6ad]/40" value="{{ old('hearing_date', optional($hearing->hearing_date)->format('Y-m-d')) }}" required>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600">Next Hearing Date</label>
                                                        <input type="date" name="next_hearing_date" class="mt-1 w-full rounded-md border-gray-200 shadow-sm focus:ring-2 focus:ring-[#37b6ad]/40" value="{{ old('next_hearing_date', optional($hearing->next_hearing_date)->format('Y-m-d')) }}">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600">Reason</label>
                                                        <input type="text" name="remarks" class="mt-1 w-full rounded-md border-gray-200 shadow-sm" value="{{ old('remarks', $hearing->remarks) }}">
                                                    </div>
                                                </div>
                                                <div class="mt-4 flex justify-end gap-2">
                                                    <button type="button" @click="openPostpone = false" class="px-4 py-2 rounded-md border">Cancel</button>
                                                    <button type="submit" class="px-4 py-2 rounded-md bg-yellow-500 text-white hover:bg-yellow-600">Save Next Date</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
