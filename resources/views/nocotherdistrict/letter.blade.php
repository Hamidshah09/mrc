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
            line-height: 2;
        }
        .para-no{
            display: flex;
            flex-direction: row;
            width: 100%;
        }
    </style>
</head>
<body style="margin: 30px;">
    <h2 class="main-heading">DEPUTY COMMISSIONER'S OFFICE</h2>
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
        <tr style="margin-top: 10px;">
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
                To
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                The Deputy Commissioner/
            </td>
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
            
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                Assistant Commissioner,
            </td>
        </tr>
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center;">
                
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-align:left;">
                {{ $letter->NOC_Issued_To }}.
            </td>
        </tr>
    </table>
    <table style="width:100%; border:none; margin-top:10px;">
        <tr>
            <td style="width:20%; padding-right:5px; vertical-align:top; border:none; text-align:center; text-weight:bold;">
                <h2 class="subject-heading">Subject</h2>
            </td>
            <td style="width:80%; vertical-align:top; border:none; text-weight:bold; text-decoration:underline;text-align:justify;">
                <h2 class="subject-heading">NO OBJECTION CERTIFICATE</h2>
            </td>
        </tr>
        <tr style="padding: 0px 15px;">
            <td style="" colspan="2">  
                <p class="text-paragraph">
                    @if ($letter->referenced_letter_no)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kindly refer to your office letter No. {{ $letter->referenced_letter_no }}, dated {{ date('d-m-Y', strtotime($letter->referenced_letter_date)) }} on the subjected cited above.
                    @else
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kindly refer to the subject cited above.
                    @endif       
                </p>
            </td>
        </tr>
        <tr style="padding: 0px 15px;">
            <td colspan="2" class="">
                
                <p class="text-paragraph">
                    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;It is stated that it is not possible to check the manual record. However, Computerized record has been inspected. As per computerized record, No domicile issued in favour of following persons from this office:-
                </p>
            </td>
        </tr>
    </table>
    <table class="records" style="align-self: center; margin-left: auto; margin-right: auto; margin-top: 20px;">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>CNIC</th>
                <th>Name of Appliant</th>
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
    <table style="width:100%; margin-top:50px; border:none;">
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
