<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 6px; border: 1px solid #ccc; }
        th { background: #f3f4f6; text-align: left; }
    </style>
</head>
<body>
    <h1>Domicile Cash Report  of {{ $title }}</h1>

    <table>
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th style="width:30%">CNIC</th>
                <th>Name</th>
                <th>Govt Fee</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cashRecords as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->cnic }}</td>
                    <td>{{ $r->name }}</td>
                    <td class="text-center">200</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center">No records found for selected filters.</td>
                </tr>
            @endforelse
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:bold;">Total Amount:</td>
                    <td style="font-weight:bold;">{{ $amount }}</td>
                </tr>
        </tbody>
    </table>
    <div style="margin-top: 30px;">
        <p style="text-align: right;width:100%;margin-right:20px;font-size:12px;font-weight:bold;">Domicile Clerk</p>

        <p style="text-decoration: underline;font-weight:bold;font-size:12px;">Acccout Assistant</p>
    </div>
</body>
</html>