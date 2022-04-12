<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Absensi KYU</title>
</head>
<body>

<div class="text-center" style="margin-top: 50px;">
    <h3>Absensi KYU</h3>

    {!! QrCode::size(300)->generate("{{ url('qrcode_blade') }}"); !!}

    <p>Silakan Scan</p>
</div>

</body>
</html>