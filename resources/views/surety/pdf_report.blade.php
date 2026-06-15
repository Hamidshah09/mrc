<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surties Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size:12px; }
        .header { text-align: center; margin-bottom: 10px; }
        .filters { text-align: center; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 6px 8px; }
        th { background: #eee; }
        .right { text-align: right; }
        .footer { margin-top: 12px; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Surties Report</h2>
    </div>
    <div class="filters">
        @if($from || $to)
            <div>Date: {{ $from ?? '---' }} to {{ $to ?? '---' }}</div>
        @else
            <div>Date: All</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:6%">ID</th>
                <th style="width:15%">Guarantor CNIC</th>
                <th style="width:20%">Guarantor Name</th>
                <th style="width:15%">Type</th>
                <th style="width:15%">Court</th>
                <th style="width:20%">Accused Name</th>
                <th style="width:9%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->guarantor_cnic }}</td>
                    <td>{{ $r->guarantor_name }}</td>
                    <td>{{ optional($r->suretyType)->name ? ucwords(optional($r->suretyType)->name) : '' }}</td>
                    <td>{{ optional($r->subDivision)->name ?? '' }}</td>
                    <td>{{ $r->accused_name }}</td>
                    <td class="right">{{ number_format($r->amount, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div>Printed by: {{ $printedBy }}</div>
        <div>Print date & time: {{ $printDate }}</div>
    </div>
</body>
</html>