<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Arms Approval Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-dates {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            word-break: break-word;
            font-size: 15px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Arms Approval Report</h2>

    <table style="margin-bottom: 10px; border:none;">
        <tr>
            <td style="width: 80px; border: none;"><strong>From:</strong></td>
            <td style="border: none;">{{ $reportDate1 }}</td>
        </tr>
        <tr>
            <td style="border: none;"><strong>To:</strong></td>
            <td style="border: none;">{{ $reportDate2 }}</td>
        </tr>
    </table>


    <table class="table">
        <thead>
            <tr>
                <th style="width:20px">#</th>
                <th style="width:130px">CNIC</th>
                <th>Name</th>
                <th style="width:150px">License No</th>
                <th style="width:100px">Request Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['cnic'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['license_no'] }}</td>
                    <td>{{ $item['request_type'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>