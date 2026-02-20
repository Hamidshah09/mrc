<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Postal Service Report</title>
     <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .records { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .records th,
        .records td {
        border: 1px solid #333; padding: 6px; text-align: center; font-size: 12px;
        }

        /* th, td { border: 1px solid #333; padding: 6px; text-align: left; font-size: 12px; }
        th { background: #f0f0f0; } */
        tfoot td { font-weight: bold; }
        .receiving-row { margin-top: 40px; width: 100%; display: flex; justify-content: space-between; }
        .receiving-box { padding: 16px 24px 32px 24px; width: 45%; min-height: 80px; display: inline-block; vertical-align: top; }
        .receiving-label { font-weight: bold; margin-bottom: 16px; display: block; font-size: 16px }
        .signature-line { margin-top: 32px; border-top: 1px solid #333; width: 80%; height: 1px; }
        .main-heading{ text-align: center; font-size: 18px; font-weight: bold; margin:0px auto; width: 100%; }
    </style>
</head>
<body>
    <h2 class="main-heading">DEPUTY COMMISSIONER'S OFFICE</h2>
    <h2 class="main-heading">ISLAMABAD CAPITAL TERRITORY</h2>
    <table style="border:none; width:100%; margin-bottom:20px;">
        <tbody >
            <tr>
                <td style="text-align: left; padding:20px;">
                    Sheet No.___________
                </td>
                <td style="text-align:right; padding:20px;">
                    Date _______________
                </td>
            </tr>
            <tr>
                <td style="text-align: left; padding:10px;"><h2>Insured Registered Letters</h2></td>
            </tr>
        </tbody>
    </table>
    
    <table class="records">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Article Number</th>
                <th>Receiver Name</th>
                <th>Receiver City</th>
                <th>Value</th>
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
                <td>{{ $row->city->name ?? 'N/A' }}</td>
                <td>5000</td>
                <td>{{ $row->weight }}</td>
                <td>{{ $row->rate }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total</td>
                <td>{{ $totalWeight }}</td>
                <td>{{ $subTotal }}</td>
            </tr>
        </tfoot>
    </table>
    <table class="records">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>No of Articiles</th>
                <th>Weight</th>
                <th>Rate Rs.</th>
                <th>Insurance Fee</th>
                <th>Total Rs.</th>
                <th>Amount Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total</td>
                <td>{{ $totalArticles }}</td>
                <td>20 grams</td>
                <td>60</td>
                <td>100</td>
                <td>160</td>
                <td>{{ $subTotal }}</td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%; margin-top:60px; border:1px solid #333; border-collapse: collapse;">
        <tr>
            <td style="width:50%; vertical-align:top; border:1px solid #333; border-collapse: collapse;">
                <div class="receiving-box" style="width:100%;">
                    <div style="height: 40px;"></div>
                    <div class="signature-line"></div>
                    <div style="font-size: 11px;font-weight: bold;">Signature Focal Person</div>
                    <div style="font-size: 11px;font-weight:bold;">Deputy Commissiner's Office</div>
                </div>
            </td>
            <td style="width:50%; vertical-align:top; border:1px solid #333; border-collapse: collapse;">
                <div class="receiving-box" style="width:100%; ">
                    <div style="height: 40px;"></div>
                    <div class="signature-line"></div>
                    <div style="font-size: 11px;font-weight: bold;">Signature Focal Person</div>
                    <div style="font-size: 11px;font-weight:bold;">Pakistan Post Office</div>
                    
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
