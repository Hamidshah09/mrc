<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; text-align: center; }
        h2 { text-align: center; margin: 0; }
        .month-title { display: block; width: 100%; background: #b2b4b8; border-radius: 5px; padding: 10px; margin-top: 12px; }
        table { width: 80%; border-collapse: collapse; border: none; margin: 12px auto; }
        th, td { padding: 8px 6px; border: none; text-align: center; }
        th { background: transparent; }
    </style>
</head>
<body>
    <h2>CITIZEN FACILITATION CENTER</h2>
    <h2>DEPUTY COMMISSIONER OFFICE</h2>
    <h2>ISLAMABAD CAPITAL TERRITORY</h2>
    <h2 class="month-title">Domicile Receipt Report for {{ $month }}</h2>

    <table>
        <thead>
            <tr>
                <th>Total No of Domiciles</th>
                <th>Total Amount Deposited</th>
            </tr>
        </thead>
        <tbody>
            
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$amount}}</td>
                </tr>
                
            
        </tbody>
    </table>
    <table style="width:80%; margin:50px auto;">
        <tr>
            <td style="width:50%;">&nbsp;</td>
            <td style="width:50%; text-align:right;">
                Domicile Clerk
            </td>
        </tr>
    </table>

</body>
</html>