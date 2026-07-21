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
    <h1>Subject: Domicile Applications for {{ $title }}</h1>
    <p style="font-size: 14px;">The following applicants have applied for the issuance of domicile certificates in this office. The cases have been examined, and all codal formalities have been duly completed.</p>
    <table>
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th style="width:30%">CNIC</th>
                <th>Name</th>
                <th>Request Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cashRecords as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $r->cnic }}</td>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->request_type }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center">No records found for selected filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <p style="font-size: 14px;display:inline-block;margin-top:20px;">2.</p>
    <span style="width:120px;display:inline-block;margin-top:20px;"></span>
    <p style="font-size: 14px;display:inline-block;margin-top:20px;">Submitted for approval</p>
    <p style="font-size: 14px;text-align:right;margin-top:20px;">Domicile Clerk</p>
    <p style="font-size: 14px;text-align:left;margin-top:20px;text-decoration:underline;text-weight:bold;">Assistant Commissioner (Saddar), ICT</p>
</body>
</html>