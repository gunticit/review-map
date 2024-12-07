<!DOCTYPE html>
<html>
<head>
    <title>Mã OTP của bạn</title>
</head>
<body>
    <h1>Mã OTP của bạn</h1>
    <p>Mã OTP: <strong>{{ $otp }}</strong></p>
    <p>Vui lòng sử dụng nó để xác thực tài khoản.</p>
    {{-- <p><a href="{{ route('register', ['email_verify' => urlencode($email)]) }}">Xác nhận ngay</a></p> --}}
</body>
</html>