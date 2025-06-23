<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #d9534f;
        }

        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .header img {
            max-width: 80px;
        }

        .header h2 {
            margin: 10px 0 5px;
            color: #d9534f;
            font-size: 20px;
            font-weight: bold;
        }

        .header p {
            font-size: 14px;
            color: #555;
        }

        .content {
            padding: 20px 10px;
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }

        .status-box {
            text-align: center;
            background-color: #d9534f;
            color: #ffffff;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 15px;
            text-transform: uppercase;
        }

        .details {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .details p {
            margin: 5px 0;
            font-size: 14px;
        }

        .details strong {
            color: #333;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 13px;
            color: #777;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .footer a {
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <img src="{{ asset('images/bfp-logo.png') }}" alt="BFP Logo">
            <h2>Bureau of Fire Protection - Abuyog</h2>
            <p>123 Fire Street, Abuyog, Leyte | Contact: (053) 555-1234</p>
        </div>

        <!-- Email Content -->
        <div class="content">
            <p>Dear <strong>Sample</strong>,</p>
            <p>We are notifying you about the latest update regarding your fire safety application.</p>

            <!-- Status Box -->
            <div class="status-box">
                Status: Sample
            </div>

            <!-- Application Details -->
            <div class="details">
                <p><strong>📌 Establishment Name:</strong> Sample</p>
                <p><strong>📍 Location:</strong> Sample</p>
            </div>

            <p>Should you have any concerns or require further assistance, feel free to reach out to our office.</p>
            <p>Thank you for your cooperation.</p>

            <p>Best regards,</p>
            <p><strong>Bureau of Fire Protection - Abuyog</strong></p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Bureau of Fire Protection - Abuyog. All rights reserved.</p>
            <p>Need help? <a href="mailto:support@bfp-abuyog.com">Contact Us</a></p>
        </div>
    </div>
</body>

</html>
