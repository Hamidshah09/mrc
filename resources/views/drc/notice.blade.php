<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divorce Notice - {{ $divorceCase->case_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; margin: 32px; }
        .toolbar { margin-bottom: 20px; }
        .notice { border: 1px solid #111827; padding: 28px; margin-bottom: 28px; page-break-inside: avoid; }
        .center { text-align: center; }
        .muted { color: #4b5563; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        td { padding: 6px 0; vertical-align: top; }
        .label { width: 170px; font-weight: bold; }
        .signature { margin-top: 70px; text-align: right; }
        @media print {
            .toolbar { display: none; }
            body { margin: 0; }
            .notice { border: 0; min-height: 46vh; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button onclick="window.print()">Print Notice</button>
    </div>

    @foreach ([
        ['title' => 'Groom Copy', 'name' => $divorceCase->groom_name, 'cnic' => $divorceCase->groom_cnic, 'address' => $divorceCase->groom_address],
        ['title' => 'Bride Copy', 'name' => $divorceCase->bride_name, 'cnic' => $divorceCase->bride_cnic, 'address' => $divorceCase->bride_address],
    ] as $party)
        <section class="notice">
            <div class="center">
                <h2>Arbitration Council</h2>
                <h3>Notice for Divorce Registration Proceedings</h3>
                <p class="muted">{{ $party['title'] }}</p>
            </div>

            <table>
                <tr><td class="label">Case No</td><td>{{ $divorceCase->case_no }}</td></tr>
                <tr><td class="label">Notice No</td><td>{{ $hearing->notice_number }}</td></tr>
                <tr><td class="label">Type of Divorce</td><td>{{ $divorceCase->divorce_type }}</td></tr>
                <tr><td class="label">Applicant</td><td>{{ ucfirst($divorceCase->applicant_side) }}</td></tr>
                <tr><td class="label">Party Name</td><td>{{ $party['name'] }}</td></tr>
                <tr><td class="label">CNIC</td><td>{{ $party['cnic'] }}</td></tr>
                <tr><td class="label">Address</td><td>{{ $party['address'] }}</td></tr>
                <tr><td class="label">Notice Date</td><td>{{ optional($hearing->notice_date)->format('d-m-Y') }}</td></tr>
                <tr><td class="label">Hearing Date</td><td>{{ optional($hearing->effective_hearing_date)->format('d-m-Y') }}</td></tr>
            </table>

            <p style="margin-top: 24px; line-height: 1.7;">
                You are directed to appear before the Chairman, Arbitration Council on the hearing date mentioned above
                for reconciliation proceedings. If either party fails to appear, the matter may proceed according to the
                available record and applicable procedure.
            </p>

            <div class="signature">
                <div>Chairman</div>
                <div>Arbitration Council</div>
            </div>
        </section>
    @endforeach
</body>
</html>
