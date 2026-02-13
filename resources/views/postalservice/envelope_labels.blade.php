<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Envelope Labels - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .label {
            border: 1px dashed #333;
            padding: 12px 18px;
            margin: 12px 0;
            width: 350px;
            height: 110px;
            display: inline-block;
            vertical-align: top;
            page-break-inside: avoid;
        }
        .label strong { font-size: 1.1em; }
        .label .address { margin-top: 6px; }
        .label .phone { margin-top: 6px; font-size: 0.95em; color: #555; }
    </style>
</head>
<body>
    <h2>Envelope Labels for {{ $date }}</h2>
    <div>
        @foreach ($labels as $label)
            <div class="label">
                <strong>{{ $label->receiver_name }}</strong><br>
                <div class="address">{{ $label->receiver_address }}</div>
                <div class="phone">{{ $label->phone_number }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
