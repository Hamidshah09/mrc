<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surety Receipt - {{ $record->id }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color:#111; }
        .container { width: 800px; margin: 0 auto; }
        .header { text-align:center; margin-bottom: 12px; }
        .title-line { font-weight:700; font-size:16px; }
        .small { font-size:12px; }

        .block { margin-top:10px; }
        .block-title { font-weight:700; margin-bottom:6px; }

        table { width:100%; border-collapse: collapse; margin-top:6px; }
        th, td { padding:8px; vertical-align: top; border:1px solid #999; text-align: left; }
        th { font-weight:700; }
        td { font-weight:400; }

        .right { text-align:right; }
        .signature { margin-top:40px; display:flex; justify-content:space-between; }
        .sig-box { width:40%; text-align:center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title-line">OFFICE OF THE DEPUTY COMMISSIONER</div>
            <div class="title-line">ISLAMABAD CAPITAL TERRITORY</div>
            <div class="title-line">NAZARAT OFFICE</div>
            <div class="small">Receipt for collection of Pay Order</div>
        </div>

        <div class="block">
            <div class="block-title">Case Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>Receipt No</th>
                        <td>{{ $record->id }}</td>
                        <th>Receiving Date</th>
                        <td>{{ optional($record->created_at)->format('d-m-Y') ?? '-' }}</td>
                        
                    </tr>
                    <tr>
                        <th>Guarantor Name</th>
                        <td>{{ $record->guarantor_name }}</td>
                        <th>Guarantor CNIC</th>
                        <td>{{ $record->guarantor_cnic ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td>{{ $record->guarantor_father_name ?? '-' }}</td>
                        <th>Mobile No</th>
                        <td>{{ $record->mobile_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Accused Name</th>
                        <td>{{ $record->accused_name ?? '-' }}</td>
                        <th>Section of Law</th>
                        <td>{{ $record->section_of_law ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Court</th>
                        <td>AC {{ $record->subdivision->name ?? '-' }}</td>
                        <th>Police Station</th>
                        <td>{{ optional($record->policeStation)->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Surety Type</th>
                        <td>{{ optional($record->suretyType)->name ?? '-' }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="block">
            <div class="block-title">Payment Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>Amount</th>
                        <td>{{ number_format($record->amount,0) }}</td>
                        <th>Payment Mode</th>
                        <td>{{ $record->payment_mode ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>PO No</th>
                        <td>{{ $record->po_no ?? '-' }}</td>
                        <th>Bank</th>
                        <td>{{ optional($record->bank)->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Branch</th>
                        <td>{{ $record->branch_name ?? '-' }}</td>
                        <th></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="signature">
            <div class="sig-box">
                
            </div>
            <div class="sig-box">
                <div>__________________________</div>
                <div>Received By</div>
                <div>{{ optional($record->user)->name ?? '-' }}</div>
            </div>
        </div>

    </div>
    <div>
        Note: Please Keep it safe. The Surety will not be return unless the original receipt is produced.
    </div>
</body>
</html>
