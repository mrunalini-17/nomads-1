<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomads Holidays: Booking Confirmation</title>
</head>
<body>
    <div class="container" style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f2e8de;">
        <div style="text-align: center; margin-bottom: 20px;">
            <!-- Company Name -->
            <img src="{{ public_path('assets/img/nomadslogoNew.png') }}" alt="Logo">
            <h2 style="margin: 10px 0; color: #333;">Nomads Holidays</h2>
        </div>

        <h2 style="color: #333; text-align: center;">Booking Confirmation</h2>


        <h4>Hello {{ $recipientName }}<h4>

        <p>Your booking with Nomads Holidays is confirmed! 🎉 Below are the details:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Guest Name</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $booking->customer->fname }} {{ $booking->customer->lname }}</td>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Booking Date</th>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M, Y') }}</td>
            </tr>

                @php
                    $amount_shareable = $booking->amount_shareable;
                    $grossAmount = $booking->bookingServices->sum('gross_amount');
                    $clientRemark = $booking->bookingRemarks->firstWhere('remark_type', 'client');
                @endphp
            @if($amount_shareable)
                <tr>
                    <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Total Amount</th>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">₹ {{ number_format($grossAmount, 2) }} {{ $booking->currency }}</td>
                    <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Total Guests</th>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $booking->passenger_count }}</td>
                </tr>
                <tr>


                    <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Remarks</th>
                    @if(optional($clientRemark)->is_shareable)
                        <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">
                            {{ $clientRemark->description ?? 'N/A' }}
                        </td>
                    @else
                        <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">N/A</td>
                    @endif
                </tr>
            @else
                <tr>
                    <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Total Guests</th>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $booking->passenger_count }}</td>

                    <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Special Requests</th>
                    @if(optional($clientRemark)->is_shareable)
                        <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">
                            {{ $clientRemark->description ?? 'N/A' }}
                        </td>
                    @else
                        <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">N/A</td>
                    @endif


                </tr>
            @endif

        </table>

        <h4 style="text-align: left; margin: 20px 0;">Service Details</h4>
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Service</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Travel Date 1</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Travel Date 2</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">PNR</th>
            </tr>
            @forelse ($booking->bookingServices as $service)
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $service->service_details ?? 'N/A' }}</td>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">
                    {{ $service->travel_date1 ? \Carbon\Carbon::parse($service->travel_date1)->format('d-m-Y') : 'N/A' }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">
                    {{ $service->travel_date2 ? \Carbon\Carbon::parse($service->travel_date2)->format('d-m-Y') : 'N/A' }}
                </td>
                <td style="padding: 8px; border: 1px solid #ddd; background-color: #f8f8f8;">{{ $service->confirmation_number ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="padding: 8px; border: 1px solid #ddd; text-align: center;">No services available</td>
            </tr>
            @endforelse
        </table>

        <p><strong>Processed by : </strong> {{ $booking->addedBy->first_name ?? '--' }} {{ $booking->addedBy->last_name ?? '--' }} ({{ $booking->addedBy->mobile ?? '--' }})</p>

        <p>If there are any discrepancies in the above details, please contact our team or reach us at our Emergency Number: +91 8408803000</p>

        <p>We look forward to making your trip memorable!</p>

        <div style="margin-top: 20px; text-align: left;">
            <p>Warm regards,</p>
            <p><strong>Nomads Holidays</strong></p>
        </div>

        <footer style="margin-top: 30px; text-align: center; color: #888;">
            <p style="font-size: 12px;">Nomads Holidays, All rights reserved.</p>
            <p style="font-size: 12px;">This is an automated email. Please do not reply to this message.</p>
        </footer>
    </div>
</body>
</html>
