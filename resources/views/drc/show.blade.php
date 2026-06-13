<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Divorce Case Detail') }}
        </h2>
    </x-slot>

    @php
        $canIssueCertificate = $divorceCase->allHearingsCompleted();
    @endphp

    <div class="w-[95%] mx-auto space-y-6 mt-10">
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

        <section class="bg-white shadow rounded p-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Case No: {{ $divorceCase->case_no }}</h3>
                    <p class="text-sm text-gray-600">{{ $divorceCase->divorce_type }} | {{ ucfirst($divorceCase->entry_type) }} Entry | Applicant: {{ ucfirst($divorceCase->applicant_side) }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('drc.edit', $divorceCase) }}" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Edit Case</a>
                    @if ($canIssueCertificate)
                        <a href="{{ route('drc.certificate', $divorceCase) }}" target="_blank" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Certificate</a>
                    @endif
                    <a href="{{ route('drc.index') }}" class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Back</a>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border border-gray-200 rounded p-4">
                    <div class="text-xs uppercase text-gray-500">Decision Date</div>
                    <div class="mt-1 font-semibold">{{ optional($divorceCase->decision_date)->format('d-m-Y') ?? 'Pending third proceeding' }}</div>
                </div>
                <div class="border border-gray-200 rounded p-4">
                    <div class="text-xs uppercase text-gray-500">Date of Issue</div>
                    <div class="mt-1 font-semibold">{{ optional($divorceCase->issue_date)->format('d-m-Y') ?? 'Pending' }}</div>
                </div>
                <div class="border border-gray-200 rounded p-4">
                    <div class="text-xs uppercase text-gray-500">Status</div>
                    <div class="mt-1 font-semibold">{{ $divorceCase->status }}</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Groom</h4>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-gray-500 w-32">Name</td><td>{{ $divorceCase->groom_name }}</td></tr>
                        <tr><td class="py-1 text-gray-500">Father Name</td><td>{{ $divorceCase->groom_father_name }}</td></tr>
                        <tr><td class="py-1 text-gray-500">CNIC</td><td>{{ $divorceCase->groom_cnic }}</td></tr>
                        <tr><td class="py-1 text-gray-500">Address</td><td>{{ $divorceCase->groom_address }}</td></tr>
                    </table>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Bride</h4>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-gray-500 w-32">Name</td><td>{{ $divorceCase->bride_name }}</td></tr>
                        <tr><td class="py-1 text-gray-500">Father Name</td><td>{{ $divorceCase->bride_father_name }}</td></tr>
                        <tr><td class="py-1 text-gray-500">CNIC</td><td>{{ $divorceCase->bride_cnic }}</td></tr>
                        <tr><td class="py-1 text-gray-500">Address</td><td>{{ $divorceCase->bride_address }}</td></tr>
                    </table>
                </div>
            </div>
        </section>

        <section class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notices and Proceedings</h3>

            <div class="space-y-5">
                @foreach ($divorceCase->hearings as $hearing)
                    <div class="border border-gray-200 rounded p-4">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-800">Notice {{ $hearing->notice_number }}</h4>
                                <p class="text-sm text-gray-500">
                                    Notice date: {{ optional($hearing->notice_date)->format('d-m-Y') }}
                                    | Hearing date: {{ optional($hearing->effective_hearing_date)->format('d-m-Y') }}
                                </p>
                            </div>
                            @if (!$hearing->isCompleted())
                                <a href="{{ route('drc.notice', [$divorceCase, $hearing]) }}" target="_blank" class="px-4 py-2 rounded bg-gray-800 text-white hover:bg-gray-700 text-center">
                                    Print Notice
                                </a>
                            @endif
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
                                        <a href="{{ asset('storage/' . $hearing->proceeding_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">View proceeding</a>
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
                            <form action="{{ route('drc.hearings.postpone', [$divorceCase, $hearing]) }}" method="POST" class="mt-4 border-t border-gray-100 pt-4">
                                @csrf
                                @method('PUT')
                                <h5 class="font-semibold text-gray-800 mb-3">Postpone Hearing</h5>
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Notice Date</label>
                                        <input type="date" name="notice_date" class="w-full border-gray-300 rounded shadow-sm"
                                               value="{{ old('notice_date', optional($hearing->notice_date)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hearing Date</label>
                                        <input type="date" name="hearing_date" class="w-full border-gray-300 rounded shadow-sm"
                                               value="{{ old('hearing_date', optional($hearing->hearing_date)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Next Hearing Date</label>
                                        <input type="date" name="next_hearing_date" class="w-full border-gray-300 rounded shadow-sm"
                                               value="{{ old('next_hearing_date', optional($hearing->next_hearing_date)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Reason</label>
                                        <input type="text" name="remarks" class="w-full border-gray-300 rounded shadow-sm"
                                               value="{{ old('remarks', $hearing->remarks) }}">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="submit" class="w-full px-4 py-2 rounded bg-yellow-600 text-white hover:bg-yellow-700">
                                            Save Next Date
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form action="{{ route('drc.hearings.complete', [$divorceCase, $hearing]) }}" method="POST" enctype="multipart/form-data" class="mt-5 border-t border-gray-100 pt-4">
                                @csrf
                                @method('PUT')
                                <h5 class="font-semibold text-gray-800 mb-3">Complete Proceeding</h5>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hearing Date</label>
                                        <input type="date" name="hearing_date" class="w-full border-gray-300 rounded shadow-sm"
                                               value="{{ old('hearing_date', optional($hearing->effective_hearing_date)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Proceeding Document</label>
                                        <input type="file" name="proceeding" class="w-full border-gray-300 rounded shadow-sm" required>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="submit" class="w-full px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                                            Mark Completed
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Proceeding Remarks</label>
                                    <textarea name="remarks" rows="2" class="w-full border-gray-300 rounded shadow-sm" required>{{ old('remarks') }}</textarea>
                                </div>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
