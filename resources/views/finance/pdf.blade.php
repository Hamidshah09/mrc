<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Arms Approval Report</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
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
            padding: 8px;
            text-align: center;
            vertical-align: top;
            word-wrap: break-word;
            word-break: break-word;
            font-size: 18px;
        }
        
    </style>
</head>
<body>
    <h2>Finance Report {{$report_date->format('d-m-Y')}}</h2>


    <table class="table">
        
        <tbody>
                <tr>
                    <td style="font-weight: 500;">Previous Balance</td>
                    <td>{{ number_format($finance_data->previous_balance) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Expense</td>
                    <td>{{"(". $finance_data->description . ") "}} {{ number_format($finance_data->expense) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Income</td>
                    <td>{{ number_format($finance_data->income) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 500;">Balance</td>
                    <td>{{ number_format($finance_data->balance) }}</td>
                </tr>
            
        </tbody>
    </table>
</body>
</html>