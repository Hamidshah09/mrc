<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Affidavit</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:14px }
        .main-heading{ text-align: center; font-size: 16px; font-weight: bold; margin:0px auto; width: 100%; }
        .text-block{ margin: 20px 0; text-align:justify; line-height:1.8 }
        .label { font-weight: bold }
        .signature { margin-top:60px }
        .page-break { page-break-after: always; }
    </style>
</head>
<body style="margin: 30px;">

@foreach($letter->applicants as $i => $applicant)
    <h2 class="main-heading">AFFIDAVIT</h2>

    <p class="text-block">
        I, <span class="label">{{ $applicant->Applicant_Name ?? '_________________________' }}</span>
        s/o <span class="label">{{ $applicant->Applicant_FName ?? '_________________________' }}</span>
        holder of CNIC <span class="label">{{ $applicant->CNIC ?? '_________________' }}</span>,
        resident of <span class="label">{{ $letter->Remarks ?? '_________________________' }}</span>
        do hereby solemnly affirm and declare as under:
    </p>

    <div class="text-block">
        <ol>
            <li>That I am a citizen of Pakistan and competent to swear this affidavit.</li>
            <li>That I have not obtained a domicile certificate from any other district of Pakistan.</li>
            <li>That I am applying for issuance of a Domicile Certificate from district <span class="label">{{ $letter->NOC_Issued_To ?? '_________________' }}</span>.</li>
            <li>That a No Objection Certificate (NOC) is required from Islamabad District for processing of my domicile application.</li>
            <li>That the contents of this affidavit are true and correct to the best of my knowledge and belief, and nothing has been concealed therein.</li>
        </ol>
    </div>

    <div class="signature">
        <div><strong>DEPONENT:</strong> ____________________________</div>
        <div style="margin-top:8px"><strong>Dated:</strong> {{ date('d-m-Y', strtotime($letter->Letter_Date ?? now())) }}</div>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
