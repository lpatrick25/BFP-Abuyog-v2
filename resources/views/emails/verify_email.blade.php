<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 2px solid #b22222;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 5px solid #b22222;
            background: #b22222;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .header img {
            max-width: 120px;
        }

        /* Main Content */
        .content {
            padding: 25px;
        }

        .content-header {
            background-color: #ffeeba;
            border-left: 6px solid #b22222;
            border-right: 6px solid #b22222;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .content-header h2 {
            color: #b22222;
            margin: 0;
            font-size: 22px;
        }

        .content-header p {
            margin: 12px 0;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        /* Details Section */
        .details {
            background: #f9f9f9;
            padding: 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #b22222;
            border-right: 4px solid #b22222;
        }

        .details p {
            font-size: 15px;
            margin: 10px 0;
        }

        .details strong {
            color: #b22222;
        }

        /* Centered CTA Button */
        .button-container {
            text-align: center;
            margin: 25px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #b22222;
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .button:hover {
            background: #8b1a1a;
        }

        /* Footer */
        .footer {
            padding: 15px;
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #8b0000;
            background: #fff3cd;
            border-radius: 6px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .footer p {
            margin: 5px 0;
            color: #8b0000;
        }

        .footer a {
            color: #8b0000;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        .footer a:hover {
            text-decoration: underline;
            color: #ff4500;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .content-header h2 {
                font-size: 20px;
            }

            .content-header p,
            .details p {
                font-size: 14px;
            }

            .button {
                font-size: 14px;
                padding: 10px 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://i.pinimg.com/originals/70/5e/28/705e28511d21d46038a6c2f3cf245eb4.png" alt="BFP Logo">
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="content-header">
                <h2>{{ $subject }}</h2>
                <p>Dear <strong>{{ optional($user->client)->getFullName() }}</strong>,</p>

                <p>
                    Thank you for signing up! To complete your registration, please verify your email address by
                    clicking the button below.
                </p>
            </div>

            <!-- Verification Details -->
            <div class="details">
                <p><strong>📧 Email:</strong> {{ $user->email }}</p>
                <p><strong>⏳ This verification link will expire in 1 minute(s).</strong></p>
            </div>

            <!-- Centered CTA Button -->
            <div class="button-container">
                <a class="button" href="{{ $verificationUrl }}">
                    ✅ Verify My Email
                </a>
            </div>

            <p>
                If you did not create an account, no further action is required.
            </p>

            <p>Thank you, <br><strong>Fire Safety Compliance Management Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>📞 Contact: (639) 16-908-5788</p>
            <p>✉️ Email: <a href="mailto:xxxxxxx@gmail.com">abuyogfsnorthleyte@gmail.com</a></p>
            <p>📍 Address: Brgy. Loyonsawang, Abuyog, Leyte, 6510</p>
            <p>🔗 Follow us on Facebook: <a href="https://www.facebook.com/AbuyogPIS" target="_blank">Abuyog
                    Fire Department</a></p>
        </div>
    </div>
</body>

</html>
