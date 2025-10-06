<!DOCTYPE html>
<html>
<head>
    <title>Report for {{ $reportDate }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-family: sans-serif; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 class="text-center">Services Report for {{ $reportDate }}</h2>
    <table>
        <thead>
            <tr>
                <th>Service</th>
                @foreach ($centers as $center)
                    <th>{{ $center->location }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($reportMatrix as $row)
                <tr>
                    <td>{{ ucfirst($row['service_name']) }}</td>

                    @foreach ($centers as $center)
                        <td>{{ ucfirst($row[$center->location]) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>