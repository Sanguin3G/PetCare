<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Quên mât khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f;
            margin: 20px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Yêu cầu đặt lại mật khẩu</h2>
        <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn.</p>
        <p>Mã xác nhận OTP của bạn là:</p>
        <div class="otp-code">{{ $OTP }}</div>
        <p>Vui lòng nhập mã này vào trang xác thực để tiếp tục quá trình đặt lại mật khẩu.</p>
        <p>Lưu ý: Mã OTP có hiệu lực trong vòng 10 phút.</p>
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
    </div>
</body>

</html>