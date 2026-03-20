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
                        No. {{ $letter->dispatchDiary->Dispatch_No }}/Domicile/Verification/2026
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
                {{ $letter->Letter_Sent_by }}
            </td>
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
            
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                {{ $letter->Designation }},
            </td>
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
                
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                {{ $letter->Sender_Address }}.
            </td>
        </tr>
        <tr style="margin-top: 10px;">
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center; text-weight:bold;">
                <h2 class="subject-heading">Subject</h2>
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-weight:bold; text-decoration:underline;text-align:justify;">
                <h2 class="subject-heading">VERIFICATION OF DOMICILE CERTIFICATE</h2>
            </td>
        </tr>
        <tr>
            <td style="" colspan="2">
                <p class="text-paragraph">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Following applicants have applied for issuance of domicile certificate from District Islamabad:-
                </p>
            </td>
        </tr>
    </table>
    <table class="records" style="align-self: center; margin-left: auto; margin-right: auto;">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>CNIC</th>
                <th>Name of Applicant</th>
                <th>Father/Husband Name</th>
    
            </tr>
        </thead>
        <tbody>
            @foreach($letter->applicants as $i => $applicant)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $applicant->CNIC }}</td>
                <td>{{ $applicant->Applicant_Name }}</td>
                <td>{{ $applicant->Applicant_FName }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width:100%; border:none;">
        <tr>
            <td style="" colspan="2">
                <p class="text-paragraph">
                        3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;It is requested that this office may be intimated whether the domicile certificate in respect of the applicant(s) mentioned above has been issued from your office or not.
                </p>
            </td>
        </tr>
    </table>
    <table style="width:100%; border:none; margin-top:40px;">
        <tr>
            <td style="width:60%" >
            </td>
            <td style="width: 40%; text-align:center;">
                <div>Incharge Domicile</div>
                <div class="">Islamabad</div>

            </td>
    </table>
    
</body>
</html>
