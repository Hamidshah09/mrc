<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divorce Certificate - {{ $divorceCase->case_no }}</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url('/fonts/Poppins-Regular.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            src: url('/fonts/Poppins-Bold.ttf') format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #111827;
            margin: 32px;
        }
        body {color: #111827; margin: 32px; }
        .toolbar { margin-bottom: 20px; }
        .certificate { border: 2px solid #111827; padding: 36px; min-height: 900px; }
        .center { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        td, th { border: none; padding: 6px; text-align: left; vertical-align: top; }
        .plain td { border: 0; padding: 6px 0; text-align: left; }
        .label { width: 150px; font-weight: bold; border:none;}
        .signature { margin-top: 90px; display: flex; justify-content: space-between; }
        @media print {
            .toolbar { display: none; }
            body { margin: 0; }
            .certificate { border: 0; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button onclick="window.print()">Print Certificate</button>
    </div>

    <section class="certificate">
        <div class="center">
            <h1 style="margin:0px;padding:0px">Chairman Arbitration Council</h1>
            <h1 style="margin:0px;padding:0px">District Islamabad</h1>
            <h3 style="margin-bottom:0px;padding-bottom:0px">Divorce Effectiveness Certificate</h3>
            <h5 style="margin:0px;padding:0px">Under Section 6 of Muslim Faimly Ordinance 1961.</h5>
        </div>

        <table class="plain">
            <tr>
                <td class="label">Application Date</td><td>{{ optional($divorceCase->application_date)->format('d-m-Y') }}</td>
                <td style="width:100px;border:none;"></td>
                <td class="label" style="text-align:right;border:none;">Case No</td><td style="text-align:right;">{{ $divorceCase->case_no }}</td>
            </tr>
            <tr><td class="label">Type of Divorce</td><td>{{ $divorceCase->divorce_type }}</td></tr>
            
        </table>

        <table>
            <tbody>
                @if ($divorceCase->applicant_side=='groom')
                    <tr><td class="label">First Party</td><td style="border:none;">{{ $divorceCase->groom_name }} s/d/o {{ $divorceCase->groom_father_name }} r/o {{ $divorceCase->groom_address }}</td></tr>
                    <tr><td class="label">Second Party</td><td style="border:none;">{{ $divorceCase->bride_name }} s/d/o {{ $divorceCase->bride_father_name }} r/o {{ $divorceCase->bride_address }}</td></tr>        
                @else 

                    <tr><td class="label">First Party</td><td style="border:none;">{{ $divorceCase->bride_name }} s/d/o {{ $divorceCase->bride_father_name }} r/o {{ $divorceCase->bride_address }}</td></tr>
                    <tr><td class="label">Second Party</td><td style="border:none;">{{ $divorceCase->groom_name }} s/d/o {{ $divorceCase->groom_father_name }} r/o {{ $divorceCase->groom_address }}</td></tr>
                    
                @endif
                
            </tbody>
        </table>
        @if ($divorceCase->divorce_type=='Talaq' && $divorceCase->applicant_side=='groom')
            <p style="margin-top: 28px; line-height: 1.7;text-align: justify;">
                First Party <span style="font-weight:bold;">{{$divorceCase->groom_name}}</span>  has given divorce to his wife, Second Party <span style="font-weight:bold;">{{$divorceCase->bride_name}}</span> with mutual consent and applied for arbitraion proceedings on {{ optional($divorceCase->application_date)->format('d-m-Y') }}. Accordingly, notices were issued and reconciliation proceedings were conducted by the Arbitration. The manditory statutory period of 90 days has been passed and both parties have not reconciled. Therefore, this divorce effectiveness registration certificate is issued. 
            </p>
        @elseif ($divorceCase->divorce_type=='Talaq' && $divorceCase->applicant_side=='bride')
            <p style="margin-top: 28px; line-height: 1.7;text-align: justify;">
                First Party <span style="font-weight:bold;">{{$divorceCase->bride_name}}</span> has stated that her husband <span style="font-weight:bold;">{{$divorceCase->groom_name}}</span>, has given divorce to her and applied for arbitraion proceedings on {{ optional($divorceCase->application_date)->format('d-m-Y') }}. Accordingly, notices were issued and reconciliation proceedings were conducted by the Arbitration. The manditory statutory period of 90 days has been passed and both parties have not reconciled. Therefore, this divorce effectiveness registration certificate is issued. 
            </p>    
        @elseif ($divorceCase->divorce_type=='khula')
            <p style="margin-top: 28px; line-height: 1.7;text-align: justify;">
                First Party <span style="font-weight:bold;">{{$divorceCase->bride_name}}</span> has obtain "Khula" from faimly court against her husband <span style="font-weight:bold;">{{$divorceCase->groom_name}}</span> and applied for arbitraion proceedings on {{ optional($divorceCase->application_date)->format('d-m-Y') }}. Accordingly, notices were issued and reconciliation proceedings were conducted by the Arbitration. The manditory statutory period of 90 days has been passed and both parties have not reconciled. Therefore, this divorce effectiveness registration certificate is issued. 
            </p>
        @elseif ($divorceCase->divorce_type=='mubarat')
            <p style="margin-top: 28px; line-height: 1.7; text-align: justify;">
                First Party <span style="font-weight:bold;">{{$divorceCase->bride_name}}</span> by using column 18 of Nikkah Nama has given divorce to her husband <span style="font-weight:bold;">{{$divorceCase->groom_name}}</span> and applied for arbitraion proceedings on {{ optional($divorceCase->application_date)->format('d-m-Y') }}. Accordingly, notices were issued and reconciliation proceedings were conducted by the Arbitration. The manditory statutory period of 90 days has been passed and both parties have not reconciled. Therefore, this divorce effectiveness registration certificate is issued. 
            </p>
        @endif

        <table>
            <tbody >
                <tr ><td class="label" style="border:none;">Decision Date</td><td style="border:none;text-align:left;">{{ optional($divorceCase->decision_date)->format('d-m-Y') }}</td></tr>
                <tr><td class="label" style="border:none;">Date of Issue:</td><td style="border:none;text-align:left;">{{ optional($divorceCase->issue_date)->format('d-m-Y') ?? 'Pending' }}</td></tr>

            </tbody>
        </table>

        <div class="signature">
            <div>
                
            </div>
            <div style="width:50%;">
                <div style="text-align: center;font-weight: bold;">Chairman</div>
                <div style="text-align: center;font-weight: bold;">Arbitration Council</div>
            </div>
        </div>
    </section>
</body>
</html>
