@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

<style>

.popup-message {
    position: fixed;
    bottom: 40px;
    right: 40px;
    background-color: #4caf50; /* Green for success */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    font-size: 16px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInOut 3s ease forwards;
}

.popup-message.error {
    background-color: #f44336;
}

@keyframes fadeInOut {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    10% {
        opacity: 1;
        transform: translateY(0);
    }
    90% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(20px);
    }
}



.table-success {
    background-color: #d4edda !important;
}


</style>
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('shared.adminsidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Topbar -->
            @include('shared.navbar')
            <!-- End of Topbar -->

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Total Bookings -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <a href="" style="color:#4e73df!important;">Total Bookings</a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $bookings }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Enquiries -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                <a href="" style="color:#36b9cc!important;">Total Enquiries</a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $enquiries }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Customers -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                <a href="" style="color:#f6c23e!important;">Total Customers</a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $customers }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Employees -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <a href="" style="color:#1cc88a!important;">Total Employees</a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $employees }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    @cannot('accounts')
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Deliverables</h6>
                        </div>
                        <div class="card-body">
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="section1-tab" data-bs-toggle="tab" href="#section1"
                                        role="tab" aria-controls="section1" aria-selected="true">Today</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="section2-tab" data-bs-toggle="tab" href="#section2"
                                        role="tab" aria-controls="section2" aria-selected="false">Tommorow</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="section3-tab" data-bs-toggle="tab" href="#section3"
                                        role="tab" aria-controls="section3" aria-selected="false">Day after tommorow</a>
                                </li>

                            </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="tabContent">
                                    <!-- Today -->
                                    <div class="tab-pane fade show active" id="section1" role="tabpanel" aria-labelledby="section1-tab">

                                        <table class="table " id="dataTable1" cellspacing="0" style="font-size: 14px;">
                                            <thead class="bg-light text-dark">
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Booking ID</th>
                                                    <th>Customer</th>
                                                    <th>Service</th>
                                                    <th>Confirmation No</th>
                                                    {{-- <th>Delivery Status</th> --}}
                                                    <th>Note</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $rowNumber = 1; @endphp
                                                @foreach ($todaysBookings as $todaysBooking)
                                                    @foreach ($todaysBooking->bookingServices as $service)
                                                        @php
                                                            // Fetch the confirmation for the relevant date
                                                            $confirmation = $service->bookingConfirmations->first();
                                                        @endphp
                                                        <tr class="{{ $confirmation && $confirmation->is_delivered ? 'table-success' : '' }}">
                                                            <td>{{ $rowNumber++ }}</td>
                                                            <td>{{ $todaysBooking->unique_code }}</td>
                                                            <td>{{ $todaysBooking->customer->fname }} {{ $todaysBooking->customer->lname }}</td>
                                                            <td>{{ $service->service_details }}</td>
                                                            <td>{{ $service->confirmation_number }}</td>
                                                            {{-- <td>
                                                                {{ $confirmation && $confirmation->is_delivered ? 'Delivered' : 'Pending' }}
                                                            </td> --}}
                                                            <td>
                                                                @if ($confirmation && $confirmation->note)
                                                                    {{ $confirmation->note }}
                                                                @else
                                                                    <div class="form-floating">
                                                                        @foreach ($service->bookingConfirmations as $confirmation)
                                                                        <textarea class="form-control form-control-sm"
                                                                                  placeholder="Add note..."
                                                                                  id="note_{{ $confirmation->id }}"
                                                                                  name="note_{{ $confirmation->id }}"
                                                                                  style="height: auto"
                                                                                  {{ $confirmation && $confirmation->is_delivered ? 'disabled' : '' }}>
                                                                        </textarea>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="text-center">
                                                                    @foreach ($service->bookingConfirmations as $confirmation)
                                                                        <button type="button"
                                                                                class="btn btn-sm btn-primary update-btn"
                                                                                id="update_{{ $confirmation->id }}"
                                                                                data-confirmation-id="{{ $confirmation->id }}"
                                                                                data-service-id="{{ $service->id }}"
                                                                                {{ $confirmation->is_delivered ? 'disabled' : '' }}>
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>


                                    <!-- Tommorow-->
                                    <div class="tab-pane fade" id="section2" role="tabpanel" aria-labelledby="section2-tab">
                                        <table class="table " id="dataTable2" cellspacing="0" style="font-size: 14px;">
                                            <thead class="bg-light text-dark">
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Booking ID</th>
                                                    <th>Customer</th>
                                                    <th>Service</th>
                                                    <th>Confirmation No</th>
                                                    {{-- <th>Delivery Status</th> --}}
                                                    <th>Note</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $rowNumber = 1; @endphp
                                                @foreach ($tomorrowsBookings as $tomorrowsBooking)
                                                    @foreach ($tomorrowsBooking->bookingServices as $service)
                                                        @php
                                                            // Fetch the confirmation for the relevant date
                                                            $confirmation = $service->bookingConfirmations->first();
                                                        @endphp
                                                        <tr class="{{ $confirmation && $confirmation->is_delivered ? 'table-success' : '' }}">
                                                            <td>{{ $rowNumber++ }}</td>
                                                            <td>{{ $tomorrowsBooking->unique_code }}</td>
                                                            <td>{{ $tomorrowsBooking->customer->fname }} {{ $tomorrowsBooking->customer->lname }}</td>
                                                            <td>{{ $service->service_details }}</td>
                                                            <td>{{ $service->confirmation_number }}</td>
                                                            {{-- <td>
                                                                {{ $confirmation && $confirmation->is_delivered ? 'Delivered' : 'Pending' }}
                                                            </td> --}}
                                                            <td>
                                                                @if ($confirmation && $confirmation->note)
                                                                    {{ $confirmation->note }}
                                                                @else
                                                                    <div class="form-floating">
                                                                        @foreach ($service->bookingConfirmations as $confirmation)
                                                                        <textarea class="form-control form-control-sm"
                                                                                  placeholder="Add note..."
                                                                                  id="note_{{ $confirmation->id }}"
                                                                                  name="note_{{ $confirmation->id }}"
                                                                                  style="height: auto"
                                                                                  {{ $confirmation && $confirmation->is_delivered ? 'disabled' : '' }}>
                                                                        </textarea>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="text-center">
                                                                    @foreach ($service->bookingConfirmations as $confirmation)
                                                                        <button type="button"
                                                                                class="btn btn-sm btn-primary update-btn"
                                                                                id="update_{{ $confirmation->id }}"
                                                                                data-confirmation-id="{{ $confirmation->id }}"
                                                                                data-service-id="{{ $service->id }}"
                                                                                {{ $confirmation->is_delivered ? 'disabled' : '' }}>
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>

                                        </table>


                                    </div>

                                    <!-- Day after Tommorow-->
                                    <div class="tab-pane fade" id="section3" role="tabpanel" aria-labelledby="section3-tab">
                                        <table class="table " id="dataTable3" cellspacing="0" style="font-size: 14px;">
                                            <thead class="bg-light text-dark">
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Booking ID</th>
                                                    <th>Customer</th>
                                                    <th>Service</th>
                                                    <th>Confirmation No</th>
                                                    {{-- <th>Delivery Status</th> --}}
                                                    <th>Note</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $rowNumber = 1; @endphp
                                                @foreach ($dayAfterTomorrowsBookings as $datBookings)
                                                    @foreach ($datBookings->bookingServices as $service)
                                                        @php
                                                            // Fetch the confirmation for the relevant date
                                                            $confirmation = $service->bookingConfirmations->first() ?? null;
                                                        @endphp
                                                        <tr class="{{ $confirmation && $confirmation->is_delivered ? 'table-success' : '' }}">
                                                            <td>{{ $rowNumber++ }}</td>
                                                            <td>{{ $datBookings->unique_code ?? 'N/A' }}</td>

                                                            <td>
                                                                @if ($datBookings->customer)
                                                                    {{ $datBookings->customer->fname ?? 'N/A' }} {{ $datBookings->customer->lname ?? '' }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>{{ $service->service_details ?? 'N/A' }}</td>
                                                            <td>{{ $service->confirmation_number ?? 'N/A' }}</td>
                                                            {{-- <td>
                                                                {{ $confirmation && $confirmation->is_delivered ? 'Delivered' : 'Pending' }}
                                                            </td> --}}
                                                            <td>
                                                                @if ($confirmation && $confirmation->note)
                                                                    {{ $confirmation->note }}
                                                                @else
                                                                    <div class="form-floating">
                                                                        @foreach ($service->bookingConfirmations as $confirmation)
                                                                        <textarea class="form-control form-control-sm"
                                                                                  placeholder="Add note..."
                                                                                  id="note_{{ $confirmation->id }}"
                                                                                  name="note_{{ $confirmation->id }}"
                                                                                  style="height: auto"
                                                                                  {{ $confirmation && $confirmation->is_delivered ? 'disabled' : '' }}>
                                                                        </textarea>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="text-center">
                                                                    @foreach ($service->bookingConfirmations as $confirmation)
                                                                        <button type="button"
                                                                                class="btn btn-sm btn-primary update-btn"
                                                                                id="update_{{ $confirmation->id }}"
                                                                                data-confirmation-id="{{ $confirmation->id }}"
                                                                                data-service-id="{{ $service->id }}"
                                                                                {{ $confirmation->is_delivered ? 'disabled' : '' }}>
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>

                                        </table>


                                    </div>
                                </div>
                        </div>
                    </div>
                    @endcannot
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            @include('shared.footer')
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateButtons = document.querySelectorAll('.update-btn');

        updateButtons.forEach(button => {
            button.addEventListener('click', function () {
                const confirmationId = $(this).data('confirmation-id');
                const serviceId = $(this).data('service-id');
                const note = document.querySelector(`#note_${confirmationId}`);

                // Disable button to prevent multiple clicks
                this.disabled = true;

                // Get the CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Make the fetch request to update the service
                fetch('{{ route("bookings.updateservice") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        confirmation_id: confirmationId,
                        service_id: serviceId,
                        note: note ? note.value.trim() : ''
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const messageBox = document.createElement('div');
                    messageBox.className = 'popup-message';
                    if (data.success) {
                        messageBox.innerText = 'Service updated successfully!';
                        const tableRow = document.querySelector(`button[data-confirmation-id="${confirmationId}"]`).closest('tr');
                            if (tableRow) {
                                tableRow.classList.add('table-success');
                            }
                    } else {
                        messageBox.innerText = 'Failed to update service: ' + data.message;
                        messageBox.classList.add('error');
                    }
                    document.body.appendChild(messageBox);

                    setTimeout(() => {
                        messageBox.remove();
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the service.');
                });
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#dataTable1, #dataTable2, #dataTable3').each(function () {
            $(this).DataTable({
                columnDefs: [
                    {
                        targets: [-1, -2],
                        orderable: false
                    }
                ]
            });
        });
    });

</script>


@endsection
