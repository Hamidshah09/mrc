<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Postal Service Report (With Receiving)</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; font-size: 12px; }
        th { background: #f0f0f0; }
        tfoot td { font-weight: bold; }
        .receiving-row { margin-top: 40px; width: 100%; display: flex; justify-content: space-between; }
        .receiving-box { padding: 16px 24px 32px 24px; width: 45%; min-height: 80px; display: inline-block; vertical-align: top; }
        .receiving-label { font-weight: bold; margin-bottom: 16px; display: block; font-size: 16px }
        .signature-line { margin-top: 32px; border-top: 1px solid #333; width: 80%; height: 1px; }
    </style>
</head>
<body>
    <h2>Postal Receiving Report</h2>
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Article Number</th>
                <th>Receiver Name</th>
                <th>Address</th>
                <th>Weight</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($records as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->article_number }}</td>
                <td>{{ $row->receiver_name }}</td>
                <td>{{ $row->receiver_address }}</td>
                <td>{{ $row->weight }}</td>
                <td>{{ $row->rate }}</td>
            </tr>
            @endforeach --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total</td>
                <td>{{ $totalWeight }}</td>
                <td>{{ $totalRate }}</td>
            </tr>
        </tfoot>
    </table>
    <table style="width:100%; margin-top:60px; border:none;">
        <tr>
            <td style="width:50%; vertical-align:top;">
                <div class="receiving-box" style="width:100%;">
                    <span class="receiving-label">Focal Person</span>
                    <span class="receiving-label">Deputy Commissioner's Office</span>
                    <div style="height: 40px;"></div>
                    <div class="signature-line"></div>
                    <span style="font-size: 11px;">Signature</span>
                </div>
            </td>
            <td style="width:50%; vertical-align:top;">
                <div class="receiving-box" style="width:100%; ">
                    <span class="receiving-label">Focal Person</span>
                    <span class="receiving-label">Pakistan Post Office</span>
                    <div style="height: 40px;"></div>
                    <div class="signature-line"></div>
                    <span style="font-size: 11px;">Signature</span>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
