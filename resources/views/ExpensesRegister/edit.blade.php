<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Expense') }}
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

        <form action="{{ route('expense_register.update', $entry->id) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Account Head</label>
                    <select name="account_head"
                           class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">Select Account Head</option>
                        @foreach ($accountheads as $head)
                            <option value="{{ $head->name }}" {{ (old('account_head', $entry->account_head) == $head->name) ? 'selected' : '' }}>{{ $head->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Amount</label>
                    <input type="text" name="amount"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ old('amount', $entry->amount) }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">Month</label>
                    <select id="month" name="month"
                           data-old="{{ old('month', $entry->month) }}"
                           class="w-full border-gray-300 rounded shadow-sm">
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Year</label>
                    <select id="year" name="year"
                           data-old="{{ old('year', $entry->year) }}"
                           class="w-full border-gray-300 rounded shadow-sm">
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Update
                </button>
                <a href="{{ route('expense_register.create') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
            </div>
        </form>
    </div>

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
