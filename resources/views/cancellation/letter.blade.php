<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NOC ICT Letter</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .records { width: 100%; border-collapse: collapse;}
        .records th,
        .records td {
        border: 1px solid #333; padding: 6px; text-align: center; font-size: 14px;
        }
        .main-heading{ text-align: center; font-size: 18px; font-weight: bold; margin:0px auto; width: 100%; }
        .subject-heading{font-size: 16px; font-weight: bold; margin:0px auto; }
        .text-paragraph{
            margin: 0px auto;
            text-align:justify;
            line-height: 1.6;
        }
    </style>
</head>
<body style="padding: 30px;">
    <h2 class="main-heading">OFFICE OF THE DEPUTY COMMISSIONER</h2>
    <h2 class="main-heading">ISLAMABAD CAPITAL TERRITORY</h2>
    <h2 class="main-heading">ISLAMABAD</h2>
    <table style="border:none; width:100%; margin-bottom:20px;">
        <tbody >
            <tr>
                <td style="text-align: left; padding:5px;">
                    @if($letter->dispatchDiary)
                        No. {{ $letter->dispatchDiary->Dispatch_No }}/Domicile/2026
                    @endif
                </td>
                <td style="text-align:right; padding:5px;">
                    Date {{ date('d-m-Y', strtotime($letter->Letter_Date)) }}
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%; border:none;">
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
                To
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                Mr./Miss. {{ $letter->Applicant_Name }}
            </td>
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
            
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                S/D/W/O {{ $letter->Father_Name }},
            </td>
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
                
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                {{ $letter->Address }}.
            </td>
        </tr>
        <tr style="margin-top: 10px;">
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center; text-weight:bold;">
                <h2 class="subject-heading">Subject</h2>
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-weight:bold; text-decoration:underline;text-align:justify;">
                <h2 class="subject-heading">CANCELLATION OF DOMICILE CERTIFICATE</h2>
            </td>
        </tr>
        <tr>
            <td style="" colspan="2">
                <p class="text-paragraph">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reference to our application, on the subject cited above.
                </p>
            </td>
        </tr>
    </table>
    <table style="width:100%; border:none;">
        <tr>
            <td style="" colspan="2">
                <p class="text-paragraph">
                        2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your domiicle certificate issued  from this office vide Domicile No. {{ $letter->Domicile_No }}, Dated {{ date('d-m-Y', strtotime($letter->Domicile_Date)) }} is hereby cancelled  on your own request and this office has no objection if the applicant applies for Domicile Certificate from any District.
                </p>
            </td>
        </tr>
    </table>
    <table style="width:100%; border:none; margin-top:40px;">
        <tr>
            <td style="width:60%" >
            </td>
            <td style="width: 40%; text-align:center;">
                <div>Incharge Domicile Branch</div>
                <div class="">Islamabad</div>

            </td>
    </table>
    
</body>
</html>
