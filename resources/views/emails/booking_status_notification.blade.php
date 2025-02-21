<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFF6E5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #FFA726;
            border-radius: 10px;
            padding: 30px;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #fff;
        }

        h1 {
            color: #E65100;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .signature {
            margin-top: 30px;
            font-size: 16px;
            text-align: right;
        }

        .signature p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Status: {{ ucfirst($booking->status) }}</h1>
        <p>Dear {{ $booking->customer->fname }} {{ $booking->customer->lname }},</p>
        <p>Your booking with ID {{ $booking->id }} is currently {{ $booking->status }}.</p>
        <p>We will notify you with further updates.</p>
        <p>Thank you for your patience.</p>
        <div class="signature">
            <p>Best Regards,</p>
            <p>Team Nomads Holidays</p>
        </div>
    </div>
</body>
</html>
