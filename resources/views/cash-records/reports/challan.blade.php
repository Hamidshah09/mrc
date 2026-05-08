<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Challan</title>

    <style>

        body{
            font-family: "Times New Roman", serif;
            font-size: 14px;
            margin: 10px;
        }

        .challan{
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .header-table td{
            vertical-align: top;
            font-size: 15px;
        }

        .main-table{
            width: 100%;
            border-collapse: collapse;
        }

        .main-table td,
        .main-table th{
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
            text-align: center;
        }

        .left{
            text-align: left !important;
        }

        .bold{
            font-weight: bold;
        }

        .total-row td{
            font-weight: bold;
        }

        .words{
            margin-top: 8px;
            margin-left: 130px;
            font-size: 16px;
        }

        .signatures{
            margin-top: 35px;
            width: 100%;
        }

        .signatures td{
            text-align: center;
            width: 25%;
            font-size: 16px;
        }

        .divider{
            margin-top: 10px;
            border-top: 1px solid #999;
        }

    </style>
</head>
<body>

@for($i = 0; $i < 2; $i++)

<div class="challan">

    <table class="header-table">
        <tr>
            <td width="33%">
                <div class="bold">CENTRAL</div>
                <div>Challan of Cash Paid in to</div>
                <div>Challan No.</div>
            </td>

            <td width="34%" align="center">
                <div>Treasury or Sub-Treasury</div>
                <div>National Bank of Pakistan</div>
                <div>State Bank of Pakistan</div>
            </td>

            <td width="33%" align="right">
                <div>Form-32/A</div>
            </td>
        </tr>
    </table>

    <table class="main-table">

        <tr>
            <td rowspan="2" width="18%" class="left">
                By whom Tender
            </td>

            <td colspan="2" width="34%">
                To be filled in the Remittes
            </td>

            <td width="18%">
                Amount
            </td>

            <td colspan="2" width="30%">
                To be filled by the the Treasury Departmental Office of the Treasury
            </td>
        </tr>

        <tr>

            <td width="17%">
                Names or designation and address of the person of whom behalf money is paid
            </td>

            <td width="17%">
                Full Particulars of the remittance and of authority (if any)
            </td>

            <td></td>

            <td width="15%">
                Head of Account
            </td>

            <td width="15%">
                Order of the Bank
            </td>
        </tr>

        <tr style="height:115px">

            <td class="left">
                Domicile Branch<br>
                DC Office, ICT<br>
                Islamabad
            </td>

            <td>
                District Magistrate<br>
                Islamabad<br>
                {{ $challanDate ?? date('Y-m-d') }}
            </td>

            <td>
                Domicile Fee<br>
                as per<br>
                attached list
            </td>

            <td class="bold">
                {{ number_format($amount ?? 0) }}
            </td>

            <td class="bold">
                C-03806
            </td>

            <td></td>
        </tr>

        <tr class="total-row">

            <td></td>
            <td></td>

            <td>
                Total
            </td>

            <td>
                {{ number_format($amount ?? 0) }}
            </td>

            <td></td>
            <td></td>

        </tr>

    </table>

    <div class="words">
        In words Rupees
        <span class="bold">
            {{ $amount_words ?? ' Only' }}
        </span>
    </div>

    <table class="signatures">
        <tr>
            <td>Signature</td>
            <td>Amount</td>
            <td>Received<br>Payment Treasury</td>
            <td>Treasury Officer</td>
        </tr>
    </table>

</div>

@if($i == 0)
    <div class="divider"></div>
@endif

@endfor

</body>
</html>