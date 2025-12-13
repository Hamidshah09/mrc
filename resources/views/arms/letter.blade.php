<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            line-height: 1;
            margin-left: 25px;
            margin-right: 25px;
            
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .letter-no{
            display: flex;
            justify-content: space-between;
        }
        .content {
            line-height: 2;
            padding: 0px;
        }
        .no-space{
            margin: 0px;
            padding: 0px;
        }
        .footer {
            font-weight: bold;
            width: 200px;
            margin-left: 60%;
            margin-top: 50px;
            text-align: center;       /* Ensures table content centers too */
        }

        .text-justify{
            text-align: justify;
            text-indent: 100px;
        }
        .bottom-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="header">
    GOVERNMENT OF PAKISTAN<br>
    OFFICE OF THE DEPUTY COMMISSIONER<br>
    ISLAMABAD CAPITAL TERRITORY<br>
    ******
</div>
<table width="100%" style="margin-bottom: 10px;">
    <tr>
        <td style="text-align: left;">No. {{$record->license_number}}/Arms/CFC</td>
        <td style="text-align: right;">Dated: {{ now()->format('d F, Y') }}</td>
    </tr>
</table>
<table style="line-height: 1.5;">
    <tr>
        <td style="margin-left: 100px;width:100px;text-align:center;">To</td>
        <td>Mr. {{$record->name}},</td>
    </tr>
    <tr>
        <td style="margin-left: 100px;width:100px"></td>
        <td>s/d/w/o {{$record->guardian_name}},</td>
    </tr>
    <tr>
        <td style="margin-left: 100px;width:100px"></td>
        <td>{{$record->address}}</td>
    </tr>
    
</table>

<p style="margin-left: 50px;"><strong>Subject: <u>NOTICE</u></strong></p>

    <div class="content">
        <p class="text-justify">{{$paragraph}}</p>
    </div>

    <div class="footer">
        <img style="height: 50px;align-items: center;" src="{{ public_path('app-icons/signature.jpeg') }}" alt="Signature">
        <table>
            <tr><td style="text-align: center;margin-bottom:0px">Deputy Commissioner,</td></tr>
            <tr><td style="text-align: center;margin:0px;">Islamabad</td></tr>
        </table>
    </div>
    <table style="line-height: 1.5; margin-top:320px;">
    <tr>
        <td style="margin-left: 100px;width:100px;text-align:center;">To</td>
        <td>Mr. {{$record->name}},</td>
    </tr>
    <tr>
        <td style="margin-left: 100px;width:100px"></td>
        <td>s/d/w/o {{$record->guardian_name}},</td>
    </tr>
    <tr>
        <td style="margin-left: 100px;width:100px"></td>
        <td>{{$record->address}}</td>
    </tr>
    @if ($record->mobile!='00000000000')
        <tr>
            <td style="margin-left: 100px;width:100px"></td>
            <td>{{$record->mobile}}</td>
        </tr>    
    @endif
    
</table>
<div class="bottom-footer">From: Deputy Commissioner's Office,  Islamabad</div>
</body>
</html>
