<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Certificate of Domicile Application</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin-top: 20px;
        color: #000;
      }

      /* Title lines with zero spacing */
      .header {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        line-height: 1; /* zero spacing between lines */
        margin-bottom: 20px;
      }

      .sub-header {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
      }

      .letter-body {
        margin-left: 20px;
      }

      .recipient {
        margin-bottom: 20px;
      }

      .paragraph {
        margin-bottom: 15px;
      }

      /* Bold and underline for key particulars */
      span {
        font-weight: bold;
        text-decoration: underline;
      }

      /* Signature section aligned right */
      .signature {
        margin-top: 40px;
        text-align: right;
      }

      .signature p {
        margin: 5px 0;
      }
      .justified {
        text-align: justify;
      }
    </style>
  </head>
  <body>
    <div class="header">
      APPENDIX - VIII<br />
      FORM 'P'<br />
      VIDE RULE 23, PAKISTAN CITIZENSHIP RULE, 1952<br />
      APPLICATION FOR CERTIFICATE OF DOMICILE PAKISTAN
    </div>

    <div class="letter-body">
      <div class="recipient">
        <p style="margin: 0px">To,</p>
        <p style="margin: 0px">The District Magistrate,</p>
        <p style="margin: 0px">Islamabad</p>
      </div>

      <div class="paragraph justified">
        <p>
          I, <span>{{$applicant->name}}</span> S/D/W/O <span>{{$applicant->fathername}}</span>,
          Date of Birth: <span>{{$applicant->date_of_birth}}</span>, Present Address:
          <span>{{$applicant->temporaryAddress}}</span>, Permanent Address:
          <span>{{$applicant->permanenAddress}}</span>, have arrived in Capital Islamabad,
          Tehsil Islamabad, District Islamabad, Rev/Admin Federal Area in
          Pakistan on <span>{{$applicant->date_of_arrival}}</span>. I have been continuously residing
          in Pakistan since <span>{{$applicant->date_of_arrival}}</span>, immediately preceding this declaration
          and I hereby express my intention to abandon my domicile of origin and
          take up my placed habitation in Pakistan during the remainder of my
          life.
        </p>
      </div>

      <div class="paragraph justified">
        <p>
          I further affirm that I had not migrated to India & returned to
          Pakistan between the 1st March 1947 to the date of this application
          except on visa No.______ dated _________ issued by the Pakistan
          Passport office at _______.
        </p>
      </div>

      <div class="paragraph details">
        <p>Other particulars are given below:</p>
        <p>Marital Status: <span>{{$applicant->marital_statuses->marital_status}}</span></p>
        <p>Name of Wife/Husband: <span>{{$applicant->spousename}}</span></p>
        <p>Name of Children & their ages including date of birth:</p>
        @foreach ($applicant->childern as $child)
          <span style="display: inline-block">{{$child->$child_name}}</span><span style="width: 10px;display:inline-block"></span><span style="display: inline-block">{{$child->$child_name}}</span>
        @endforeach
        <p>Trade & Occupation: <span>{{$applicant->occupations->occupation}}</span></p>
      </div>

      <div class="paragraph">
        <p>
          I do solemnly affirm that the above statement is true to the best of
          my knowledge and belief.
        </p>
      </div>

      <div class="signature">
        <p>Signature: ________________</p>
        <p>CNIC: <span>{{$applicant->cnic}}</span></p>
        <p>Contact: <span>{{$applicant->contact}}</span></p>
      </div>
    </div>
  </body>
</html>
