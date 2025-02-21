@extends('layout.app')
@section('title', 'Booking Details')

<style>
    .highlight {
    background-color: #ecd0d8; /* Highlight color */
}

</style>
@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('shared.adminsidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('shared.navbar')
                <!-- End of Topbar -->



        <!-- Content Wrapper -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="py-3 px-2">
                <h3 class="font-weight-bold text-primary">Booking Details</h3>
            </div>

            <!-- Back Button -->
            <div class="text-right mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                     Back
                </a>
            </div>

            <!-- Booking Details -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">ID : {{ $booking->unique_code }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><strong>Customer:</strong> {{ $booking->customer->fname ?? 'N/A' }}
                                    {{ $booking->customer->lname ?? '' }}</td>
                                <td><strong>Customer Manager:</strong> {{ $booking->customerManager->fname ?? 'N/A' }}
                                    {{ $booking->customerManager->lname ?? '' }}</td>
                                <td><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>

                                <td><strong>Passenger Count:</strong> {{ $booking->passenger_count ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Service:</strong> {{ $booking->service->name ?? 'N/A' }}</td>
                                <td><strong>Status:</strong> {{ $booking->status ?? 'N/A' }}</td>
                                <td><strong>Bill To:</strong>
                                    @if ($booking->bill_to === 'self' || $booking->bill_to === 'other')
                                        {{ $booking->bill_to_remark ?? 'N/A' }}
                                    @elseif($booking->bill_to === 'company' && $booking->company)
                                        <div>
                                            <strong>Company Name:</strong> {{ $booking->company->name ?? 'N/A' }}<br>
                                            <strong>Mobile:</strong> {{ $booking->company->mobile ?? 'N/A' }}<br>
                                            <strong>GST:</strong> {{ $booking->company->gst ?? 'N/A' }}<br>
                                            <strong>Address:</strong> {{ $booking->company->address ?? 'N/A' }}
                                        </div>
                                    @else
                                        {{ $booking->bill_to ?? 'N/A' }}
                                    @endif
                                </td>
                                <td><strong>PAN Number:</strong> {{ $booking->pan_number ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Invoice Number:</strong> {{ $booking->invoice_number ?? 'N/A' }}</td>
                                <td><strong>Payment Status:</strong> {{ $booking->payment_status ?? 'N/A' }}</td>
                                <td><strong>Payment Received Remark:</strong>
                                    {{ $booking->payment_received_remark ?? 'N/A' }}</td>
                                <td><strong>Office Reminder:</strong> {{ $booking->office_reminder ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td><strong>Cancelled:</strong> {{ $booking->is_cancelled ? 'Yes' : 'No' }}</td>
                                <td><strong>Mail & Message:</strong> {{ $booking->mm_shareable ? 'Sent' : 'Not sent' }}</td>
                                <td>
                                    <strong>Bill Amount:</strong>
                                    @if ($booking->mm_shareable && $booking->amount_shareable)
                                        Shared
                                    @else
                                        Not shared
                                    @endif
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>


            @if($booking->is_cancelled && $cancellation)
            <!-- Cancellation Details -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">Cancellation Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><strong>Reason:</strong> {{ $cancellation->reason ?? 'N/A' }}</td>
                                <td><strong>Cancellation Charges:</strong> {{ $cancellation->charges ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Details:</strong> {{ $cancellation->details ?? 'N/A' }}</td>
                                <td><strong>Charges Received:</strong>
                                    @if(is_null($cancellation->charges_received))
                                        N/A
                                    @elseif($cancellation->charges_received)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Passenger Information -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">Passenger Information</h5>
                </div>
                <div class="card-body">
                    @if ($booking->passengerCounts->isNotEmpty())
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    {{-- <th>Age</th> --}}
                                    <th>Gender</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking->passengerCounts as $passenger)
                                    <tr>
                                        <td>{{ $passenger->name ?? 'N/A' }}</td>
                                        {{-- <td>{{ $passenger->age ?? 'N/A' }}</td> --}}
                                        <td>{{ $passenger->gender ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No passenger information available.</p>
                    @endif
                </div>
            </div>


            <!-- Service Details -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">Service Details</h5>
                </div>
                <div class="card-body">
                    @forelse ($booking->bookingServices as $index => $service)
                        <div class="mb-4">
                            <h6>
                                <strong>Service {{ $index + 1 }}:</strong>
                                @if(is_null($service->updates))
                                    <strong style="color:green;">Old</strong>
                                @else
                                    <strong style="color:red;">Revised</strong>
                                @endif
                            </h6>

                            <table class="table table-bordered table-striped">
                                <tbody>
                                    @php
                                        $updates = json_decode($service->updates, true) ?? [];
                                    @endphp
                                    <tr>
                                        <td class="{{ in_array('service_details', $updates) ? 'highlight' : '' }}">
                                            <strong>Service Details:</strong> {{ $service->service_details ?? 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('travel_date1', $updates) ? 'highlight' : '' }}">
                                            <strong>Travel Date 1:</strong> {{ $service->travel_date1 ? \Carbon\Carbon::parse($service->travel_date1)->format('d-m-Y') : 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('travel_date2', $updates) ? 'highlight' : '' }}">
                                            <strong>Travel Date 2:</strong> {{ $service->travel_date2 ? \Carbon\Carbon::parse($service->travel_date2)->format('d-m-Y') : 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('confirmation_number', $updates) ? 'highlight' : '' }}">
                                            <strong>Confirmation Number:</strong> {{ $service->confirmation_number ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="{{ in_array('gross_amount', $updates) ? 'highlight' : '' }}">
                                            <strong>Gross Amount:</strong> {{ $service->gross_amount ?? 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('net', $updates) ? 'highlight' : '' }}">
                                            <strong>Net Amount:</strong> {{ $service->net ?? 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('service_fees', $updates) ? 'highlight' : '' }}">
                                            <strong>Service Fees:</strong> {{ $service->service_fees ?? 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('mask_fees', $updates) ? 'highlight' : '' }}">
                                            <strong>Mask Fees:</strong> {{ $service->mask_fees ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        @if($service->tcs)
                                            <td class="{{ in_array('tcs', $updates) ? 'highlight' : '' }}">
                                                <strong>TCS:</strong> {{ $service->tcs ?? 'N/A' }}
                                            </td>
                                        @endif
                                        <td class="{{ in_array('card_id', $updates) ? 'highlight' : '' }}">
                                            <strong>Card:</strong> {{ $service->card->card_name ?? 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('supplier_id', $updates) ? 'highlight' : '' }}">
                                            <strong>Supplier:</strong> {{ $service->supplier->name ?? 'N/A' }}
                                        </td>
                                        <td class="{{ in_array('bill_to', $updates) || in_array('bill_to_remark', $updates) ? 'highlight' : '' }}">
                                            <strong>Bill To:</strong> {{ ucfirst($service->bill_to) ?? 'N/A' }} - {{ $service->bill_to_remark ?? 'N/A' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <p class="text-muted">No service details available.</p>
                    @endforelse
                </div>

            </div>

            <!-- Remarks -->
            {{-- @if ($booking->bookingRemarks->contains('remark_type', 'account')) --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="m-0">Remarks</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Remark Type</th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Shared</th>
                                    <th>Added by</th>
                                    @can('accounts')
                                    <th>Acknowledge<span class="text-danger">*</span></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php $counter = 0; @endphp --}}
                                @forelse ($booking->bookingRemarks as $remark)
                                    @can('accounts')
                                        @if ($remark->remark_type !== 'account')
                                            @continue
                                        @endif
                                    @endcan
                                    <tr>
                                        <td>{{ ucfirst($remark->remark_type) }}</td>
                                        <td>{{ $remark->description ?? 'N/A' }}</td>
                                        <td>{{ $remark->created_at->format('d/m/Y') }}</td> <!-- Format Date -->
                                        <td>{{ $remark->created_at->format('H:i') }}</td>
                                        <td>{{ $remark->is_shareable ? 'Yes' : 'No' }}</td>
                                        <td>{{ $remark->addedBy->first_name ?? 'N/A' }} {{ $remark->addedBy->last_name ?? 'N/A' }}</td>
                                        @can('accounts')
                                            <td>
                                                @if (!$remark->is_acknowledged) <!-- Only show checkbox if not acknowledged -->
                                                    {{-- @php $counter++; @endphp --}}
                                                    <input type="checkbox" name="is_ack" id="is_ack_{{ $remark->id }}"
                                                        class="form-check-input is-ack-checkbox" style="position: relative; margin-left:2px;">
                                                @else
                                                    <!-- Green Tick Mark for Acknowledged Remarks -->
                                                    <span class="text-success" style="font-size: 20px;">&#10003;</span> <!-- Check mark symbol -->
                                                @endif
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted text-center">No remarks available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- @if($counter>0)
                    <div class="card-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-primary accept"
                            onclick="handleAcknowledegeButton({{ $booking->id }})">
                        Acknowledge
                    </button>
                    </div>
                    @endif --}}
                </div>
            {{-- @endif --}}

            <!-- Approval -->
            @can('accounts')
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Approval</h5>
                    <button class="btn btn-link text-white toggle-collapse" data-bs-toggle="collapse" data-bs-target="#approvalCollapse" aria-expanded="true" aria-controls="approvalCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>

                <div id="approvalCollapse" class="collapse">

                    <form action="{{ route('booking.approve', $booking->id) }}" id="approval_form" method="POST">
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="invoice_number" class="form-label">Invoice Number</label>
                                    <input type="text" name="invoice_number" id="invoice_number" class="form-control"
                                        placeholder="Enter Invoice Number"
                                        value="{{ old('invoice_number', $booking->invoice_number) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-center">
                            <input type="hidden" name="approve" value="1">
                            <button type="submit" id="approve_button" class="btn btn-secondary approve"
                                data-booking-id="{{ $booking->id }}"
                                onclick="handleAcknowledgeButton(event, {{ $booking->id }})">Approve</button>
                        </div>
                    </form>


                </div>
            </div>


            <!-- Add Remarks -->
            <div class="card mb-4 shadow-sm">

                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Add Remarks</h5>
                    <button class="btn btn-link text-white toggle-collapse" data-bs-toggle="collapse" data-bs-target="#addremarksCollapse" aria-expanded="true" aria-controls="addremarksCollapse">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div id="addremarksCollapse" class="collapse">
                {{-- <form action="{{ route('new_booking.add_remark', $booking->id) }}" id="add_remarks_form" method="POST"> --}}
                    <form action="" id="add_remarks_form" method="POST">
                    <div class="card-body">
                            @csrf
                            <div class="row">
                                <div id="remarksContainer" class="col-12 col-md-12">
                                    <div class="remark-group row col-12 col-md-12" id="remark_group_1">
                                        <div class="mb-3 col col-4">
                                            <label for="remark_type" class="form-label">Remark Type </label>
                                            <select name="remark_type" id="remark_type" class="form-select form-control">
                                                <option value="" disabled>Select</option>
                                                <option value="office">Office</option>
                                                <option value="account">Accounts</option>
                                            </select>
                                            @error('remark_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col col-8">
                                            <label for="remark" class="form-label">Remark </label>
                                            <textarea name="remark" id="remark" cols="" rows="" class="form-control"></textarea>
                                            @error('remark')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div class="card-footer d-flex justify-content-center">
                        <input type="hidden" name="update" value="1">
                        <button type="button" id="update_button" class="btn btn-secondary update" data-booking-id="{{$booking->id}}">Update</button>
                    </div>

                </form>
            </div>
            </div>

            {{-- @if( !$booking->is_accepted)
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-success accept"
                            onclick="handleAcceptButton({{ $booking->id }})">
                        Acknowledge
                    </button>
                </div>
            @endif --}}

            @endcan
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    @include('shared.footer')
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script>
        function handleAcknowledgeButton(event, bookingId) {
            event.preventDefault();

            const checkboxes = document.querySelectorAll('.is-ack-checkbox');

            // Check if there are any checkboxes in the DOM
            if (checkboxes.length === 0) {
                document.getElementById('approval_form').submit();
                return;
            }

            // Check if all checkboxes are checked
            const areAllChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            if (areAllChecked) {
                document.getElementById('approval_form').submit();
            } else {
                alert('Please acknowledge all remarks by checking each box before proceeding.');
            }
        }


        function sendAjaxRequest(bookingId) {
            fetch(`/bookings/accept/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Optionally, refresh the page or update the UI
                } else {
                    alert('Failed to acknowledge the remarks the booking. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(data.message);
            });
        }

        function approveBooking(bookingId) {
            fetch(`/bookings/approve/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Optionally, refresh the page or update the UI
                } else {
                    alert('Failed to accept the booking. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(data.message);
            });
        }

    </script>


<script>
    document.querySelector('.toggle-collapse').addEventListener('click', function () {
        const icon = this.querySelector('i');
        const isCollapsed = this.getAttribute('aria-expanded') === 'true';

        if (isCollapsed) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });
</script>

@endsection
