<!DOCTYPE html>
<html>

<head>
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f9f9f9;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Email Address</h1>
        </div>

        <div class="content">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>

            <p>Thank you for registering with our application. Please click the button below to verify your email address:</p>

            <p style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button" style="color: #fff">Verify Email Address</a>
            </p>

            <p>If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>

            <p style="word-break: break-all;">
                <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
            </p>

            <p>If you did not create an account, no further action is required.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your App Name. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
