<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomads Holidays: New Employee Login credentials</title>
</head>
<body>
    <div class="container" style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f2e8de;">
        <div style="text-align: center; margin-bottom: 20px;">
            <!-- SVG Logo -->
            <img src="{{ asset('images/nomad_logo.svg') }}" alt="Logo Nomads Holidays" style="width: 100px; height: auto;">

            <!-- Company Name -->
            <h2 style="margin: 10px 0; color: #333;">Nomads Holidays</h2>
        </div>

        <h2 style="color: #333; text-align: center;">Your Login Credentials</h2>

        <h4>Welcome, {{ $employee->first_name }} {{ $employee->last_name }}</h4>

        <p>Your account has been created. Use the following credentials to login to your account:</p>

        <ul>
            <li>Login URL: <a href="{{ url('/') }}">www.nomads</a></li>
            <li>Username: {{ $employee->mobile }}</li>
            <li>Password: {{ $password }}</li>
        </ul>

        <p>Please change your password after logging in for the first time.</p>

        <p>For any queries or updates, contact your Team Head or Admin.</p>

        <div style="margin-top: 20px; text-align: left;">
            <p><strong>Nomads Holidays</strong></p>
        </div>

        <footer style="margin-top: 30px; text-align: center; color: #888;">
            <p style="font-size: 12px;">Nomads Holidays, All rights reserved.</p>
            <p style="font-size: 12px;">This is an automated email. Please do not reply to this message.</p>
        </footer>
    </div>
</body>
</html>
