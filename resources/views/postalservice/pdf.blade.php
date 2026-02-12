<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Postal Service Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; font-size: 12px; }
        th { background: #f0f0f0; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Postal Summary</h2>
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
            @foreach($records as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->article_number }}</td>
                <td>{{ $row->receiver_name }}</td>
                <td>{{ $row->receiver_address }}</td>
                <td>{{ $row->weight }}</td>
                <td>{{ $row->rate }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total</td>
                <td>{{ $totalWeight }}</td>
                <td>{{ $totalRate }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
