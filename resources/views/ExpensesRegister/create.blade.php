<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Expense') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded-md border border-red-300">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expense_register.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Account Head</label>
                    <select name="account_head"
                           class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">Select Account Head</option>
                        @foreach ($accountheads as $head)
                            <option value="{{ $head->name }}" {{ old('account_head') == $head->name ? 'selected' : '' }}>{{ $head->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Amount</label>
                    <input type="number" name="amount" step="0.01" min="0" inputmode="decimal"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('amount') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">Month</label>
                    <select id="month" name="month"
                           data-old="{{ old('month', request('month')) }}"
                           class="w-full border-gray-300 rounded shadow-sm">
                        @php
                            $months = [
                                'January','February','March','April','May','June','July','August','September','October','November','December'
                            ];
                            $selectedMonth = old('month', request('month'));
                        @endphp
                        @foreach($months as $m)
                            <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Year</label>
                    <select id="year" name="year"
                           data-old="{{ old('year', request('year')) }}"
                           class="w-full border-gray-300 rounded shadow-sm">
                        @php
                            $currentYear = date('Y');
                            $selectedYear = old('year', request('year', $currentYear));
                        @endphp
                        @for($y = $currentYear; $y <= $currentYear + 2; $y++)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>
    </div>
    @if(isset($recentEntries) && $recentEntries->count())
        <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-6">
            <h3 class="font-semibold text-lg mb-3">Last 10 Entries</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left px-3 py-2">Account Head</th>
                            <th class="text-right px-3 py-2">Amount</th>
                            <th class="text-left px-3 py-2">Month</th>
                            <th class="text-left px-3 py-2">Year</th>
                            <th class="text-left px-3 py-2">Date</th>
                            <th class="text-left px-3 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEntries as $entry)
                            <tr class="border-t">
                                <td class="px-3 py-2">{{ $entry->account_head }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($entry->amount, 2) }}</td>
                                <td class="px-3 py-2">{{ $entry->month }}</td>
                                <td class="px-3 py-2">{{ $entry->year }}</td>
                                <td class="px-3 py-2">{{ optional($entry->created_at)->format('Y-m-d') }}</td>
                                <td class="px-3 py-2">
                                    <a href="{{ route('expense_register.edit', $entry->id) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const month = document.getElementById('month');
            const year = document.getElementById('year');
            if (!month || !year) return;

            const oldMonth = month.dataset.old || '';
            const oldYear = year.dataset.old || '';
            const storedMonth = localStorage.getItem('expenses_month');
            const storedYear = localStorage.getItem('expenses_year');

            if (oldMonth) month.value = oldMonth;
            else if (storedMonth) month.value = storedMonth;

            if (oldYear) year.value = oldYear;
            else if (storedYear) year.value = storedYear;

            month.addEventListener('change', function () {
                localStorage.setItem('expenses_month', month.value);
            });

            year.addEventListener('change', function () {
                localStorage.setItem('expenses_year', year.value);
            });
        });
    </script>

</x-app-layout>
