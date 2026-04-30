<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Marriage') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-10">

    <h1>Expense Register Summary</h1>

    <form method="GET" action="{{ route('expense_register.index') }}" class="form-inline mb-3">
        <select name="month" class="form-control mr-2">
            <option value="">All Months</option>
            @foreach($months as $m)
                <option value="{{ $m }}" {{ (isset($month) && $month == $m) ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
        </select>

        <select name="year" class="form-control mr-2">
            <option value="">All Years</option>
            @foreach($years as $y)
                <option value="{{ $y }}" {{ (isset($year) && $year == $y) ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>

        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('expense_register.create') }}" class="btn btn-secondary ml-2">Add Expense</a>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Head of Account</th>
                    <th>Entries</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($summary as $row)
                    <tr>
                        <td>{{ $row->account_head }}</td>
                        <td>{{ $row->count }}</td>
                        <td>{{ number_format($row->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No records found.</td>
                    </tr>
                @endforelse
                <tr>
                    <td><strong>Grand Total</strong></td>
                    <td></td>
                    <td><strong>{{ number_format($grandTotal, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
