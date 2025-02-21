<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomads Holidays: New Enquiry Notification</title>
</head>
<body>
    <div class="container" style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f2e8de;">
        <div style="text-align: center; margin-bottom: 20px;">
            <!-- SVG Logo -->

            <!-- Company Name -->
            <img src="{{ public_path('assets/img/nomadslogoNew.png') }}" alt="Logo">
            <h2 style="margin: 10px 0; color: #333;">Nomads Holidays</h2>
        </div>

        <h2 style="color: #333; text-align: center;">New Enquiry</h2>


        <h4>Hello {{$recipientName}},</h4>

        <p>A new enquiry has been assigned to you by {{ optional($enquiry->addedBy)->first_name . ' ' . optional($enquiry->addedBy)->last_name }}. Please review the details below:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">ID</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $enquiry->unique_code }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Guest Name</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $enquiry->fname ?? 'N/A' }} {{ $enquiry->lname ?? '' }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Contact Number</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $enquiry->mobile ?? '--' }}, {{ $enquiry->whatsapp ?? '--' }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Note</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $enquiry->note }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Source</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $enquiry->source->title }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Priority</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ ucfirst($enquiry->priority) }}</td>
            </tr>
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Assigned To</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">
                    @if($enquiry->employees->isNotEmpty())
                        {{ $enquiry->employees->map(function($employee) {
                            return $employee->first_name . ' ' . $employee->last_name;
                        })->join(', ') }}
                    @else
                        --
                    @endif
                </td>
            </tr>
        </table>



        <p>Please connect with the guest at the earliest to assist them with their travel plans.</p>

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
