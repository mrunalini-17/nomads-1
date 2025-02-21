<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomads Holidays: Booking Confirmation</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/pdf-style.css') }}">
</head>
<body>
    <!-- Header -->
    <img src="{{ public_path('assets/img/nomadslogoNew.png') }}" alt="Nomads Holidays Logo">

    <!-- Watermark -->
    <div class="watermark">Nomads</div>

    <!-- Main Content -->
    <h2 style="text-align: center;">Booking Confirmation</h2>
    <h4>Hello {{ $booking->customer->fname }}  {{ $booking->customer->lname }}</h4>
    <p>Your booking with Nomads Holidays is confirmed! Below are the details:</p>

    <table>
        <tr>
            <th>Guest Name</th>
            <td>{{ $booking->customer->fname }} {{ $booking->customer->lname }}</td>
            <th>Booking Date</th>
            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M, Y') }}</td>
        </tr>
        @php
            $amount_shareable = $booking->amount_shareable;
            $grossAmount = $booking->bookingServices->sum('gross_amount');
            $clientRemark = $booking->bookingRemarks->firstWhere('remark_type', 'client');
        @endphp
        @if($amount_shareable)
            <tr>
                <th>Total Amount</th>
                <td>₹ {{ number_format($grossAmount, 2) }} {{ $booking->currency }}</td>
                <th>Total Guests</th>
                <td>{{ $booking->passenger_count }}</td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td>{{ optional($clientRemark)->is_shareable ? $clientRemark->description ?? 'N/A' : 'N/A' }}</td>
            </tr>
        @else
            <tr>
                <th>Total Guests</th>
                <td>{{ $booking->passenger_count }}</td>
                <th>Special Requests</th>
                <td>{{ optional($clientRemark)->is_shareable ? $clientRemark->description ?? 'N/A' : 'N/A' }}</td>
            </tr>
        @endif
    </table>

    <h4>Service Details</h4>
    <table>
        <tr>
            <th>Service</th>
            <th>Travel Date 1</th>
            <th>Travel Date 2</th>
            <th>PNR</th>
        </tr>
        @forelse ($booking->bookingServices as $service)
            <tr>
                <td>{{ $service->service_details ?? 'N/A' }}</td>
                <td>{{ $service->travel_date1 ? \Carbon\Carbon::parse($service->travel_date1)->format('d-m-Y') : 'N/A' }}</td>
                <td>{{ $service->travel_date2 ? \Carbon\Carbon::parse($service->travel_date2)->format('d-m-Y') : 'N/A' }}</td>
                <td>{{ $service->confirmation_number ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">No services available</td>
            </tr>
        @endforelse
    </table>

    <p><strong>Processed by :</strong> {{ $booking->addedBy->first_name ?? '--' }} {{ $booking->addedBy->last_name ?? '--' }} ({{ $booking->addedBy->mobile ?? '--' }})</p>
    <p>If there are any discrepancies, contact our team or reach us at +91 8408803000</p>
    <p>We look forward to making your trip memorable!</p>

    <!-- Footer -->
    <div class="footer">
        <hr>
        <div class="contact">
            Support <span style="color:darkred;">☎</span> 8408803000 | 8408803000
        </div>
    </div>
</body>
</html>
