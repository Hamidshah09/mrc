<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divorce Certificate - {{ $divorceCase->case_no }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; margin: 32px; }
        .toolbar { margin-bottom: 20px; }
        .certificate { border: 2px solid #111827; padding: 36px; min-height: 900px; }
        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        td, th { border: 1px solid #d1d5db; padding: 9px; text-align: left; vertical-align: top; }
        .plain td { border: 0; padding: 6px 0; }
        .label { width: 190px; font-weight: bold; }
        .signature { margin-top: 90px; display: flex; justify-content: space-between; }
        @media print {
            .toolbar { display: none; }
            body { margin: 0; }
            .certificate { border: 0; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button onclick="window.print()">Print Certificate</button>
    </div>

    <section class="certificate">
        <div class="center">
            <h1>Chairman Arbitration Council</h1>
            <h3>District Islamabad</h3>
        </div>

        <table class="plain">
            <tr><td class="label">Case No</td><td>{{ $divorceCase->case_no }}</td></tr>
            <tr><td class="label">Type of Divorce</td><td>{{ $divorceCase->divorce_type }}</td></tr>
            <tr><td class="label">Decision Date</td><td>{{ optional($divorceCase->decision_date)->format('d-m-Y') }}</td></tr>
            <tr><td class="label">Date of Issue</td><td>{{ optional($divorceCase->issue_date)->format('d-m-Y') ?? 'Pending' }}</td></tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Groom</th>
                    <th>Bride</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Name</td><td>{{ $divorceCase->groom_name }}</td><td>{{ $divorceCase->bride_name }}</td></tr>
                <tr><td>Father Name</td><td>{{ $divorceCase->groom_father_name }}</td><td>{{ $divorceCase->bride_father_name }}</td></tr>
                <tr><td>CNIC</td><td>{{ $divorceCase->groom_cnic }}</td><td>{{ $divorceCase->bride_cnic }}</td></tr>
                <tr><td>Address</td><td>{{ $divorceCase->groom_address }}</td><td>{{ $divorceCase->bride_address }}</td></tr>
            </tbody>
        </table>

        <p style="margin-top: 28px; line-height: 1.7;">
            This is certified that notices were issued and reconciliation proceedings were conducted by the Arbitration
            Council. After completion of the statutory period and non-reconciliation of both parties, this divorce
            registration certificate is issued according to the record maintained by this office.
        </p>

        <table>
            <thead>
                <tr>
                    <th>Notice</th>
                    <th>Notice Date</th>
                    <th>Hearing Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($divorceCase->hearings as $hearing)
                    <tr>
                        <td>{{ $hearing->notice_number }}</td>
                        <td>{{ optional($hearing->notice_date)->format('d-m-Y') }}</td>
                        <td>{{ optional($hearing->hearing_date)->format('d-m-Y') }}</td>
                        <td>{{ $hearing->isCompleted() ? 'Completed' : ucfirst($hearing->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature">
            <div>
                <div>Prepared By</div>
                <div style="margin-top: 36px; border-top: 1px solid #111827; width: 180px;"></div>
            </div>
            <div>
                <div>Chairman, Arbitration Council</div>
                <div style="margin-top: 36px; border-top: 1px solid #111827; width: 220px;"></div>
            </div>
        </div>
    </section>
</body>
</html>
