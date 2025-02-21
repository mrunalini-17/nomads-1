@extends('layout.app')
@section('title', 'Bookings Report')

<style>
    div .dt-buttons{
        margin-bottom: 8px;
    }
    .dataTables_wrapper .dataTable {
        white-space: pre-wrap;
    }

    .select2-container--bootstrap-5 .select2-selection--single {
    height: calc(2.25rem + 2px);  /* Match the height of Bootstrap select */
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}

.select2-container--bootstrap-5 .select2-selection__arrow {
    height: calc(2.25rem + 2px);  /* Align the arrow with the select input */
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    {{-- Head --}}
                    <div class="py-3 px-2">
                        <h3 class="font-weight-bold text-primary">Booking Reports</h3>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="filters">
                                <form action="{{ route('bookingreport')}}" id="bookingReportForm" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="customer">Select Customer</label>
                                                <select class="select2 form-select" name="customer" id="customer">
                                                    <option value="">Select</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->fname }} {{ $customer->lname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="customer">Search Booking ID</label>
                                                <input type="text" name="unique_code" id="unique_code" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="services" class="form-label">Select Service </label>
                                            <select name="service" id="service" class="select2 form-control">
                                                <option value="" disable>Select</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="" disable>Select</option>
                                                <option value="Hold">Hold</option>
                                                <option value="Confirmed">Confirmed</option>
                                                <option value="Rebooked">Rebooked</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="added_by" class="form-label">Added by</label>
                                            <select class="select2 form-control" id="added_by" name="added_by">
                                                <option value="" disable>Select</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="added_by" class="form-label">Accepted</label>
                                            <select class="form-control" id="accepted" name="accepted">
                                                <option value="" disable>Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

                                        <!-- From Date -->
                                        <div class="col-md-3 mb-3">
                                            <label for="from_date" class="form-label">From Date</label>
                                            <input type="date" class="form-control" id="from_date" name="from_date">
                                            <small id="fromdate-error" class="text-danger"></small>
                                        </div>

                                        <!-- To Date -->
                                        <div class="col-md-3 mb-3">
                                            <label for="to_date" class="form-label">To Date</label>
                                            <input type="date" class="form-control" id="to_date" name="to_date">
                                            <small id="todate-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-primary mx-2">Search</button>
                                            <button type="button" id="resetButton" class="btn btn-secondary mx-2">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <br><br>



                            <!-- Table container for dynamic results -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="bookingTable" cellspacing="0">
                                    <thead class="bg-light text-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Booking Date</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th>Added by</th>
                                            <th>Accepted by</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bookingTableBody">
                                        <!-- Rows will be inserted here by AJAX -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
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



<script>

$(document).ready(function() {
    // Apply Select2
    $('.select2').select2({
        allowClear: true,
        width: '100%'
    });

    // Initialize DataTable once
    var table = $('#bookingTable').DataTable({
        dom: 'Bfrtip',
        searching: false,
        buttons: [
            {
            extend: 'excelHtml5',
            text: 'Excel',
            title: 'Booking Report',
            className: 'btn btn-primary'
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'Booking Report',
            // orientation: 'landscape',
            pageSize: 'A4',
            className: 'btn btn-secondary'
        },
        {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-success'
        }
        ],
        initComplete: function () {
        // Apply Bootstrap button classes to DataTable buttons
        $('.dt-button').removeClass('dt-button').addClass('btn btn-primary mx-1');
    }
    });

    $('#resetButton').on('click', function() {
        // Reset all input fields
        $('#bookingReportForm')[0].reset();

        $('.select2').val(null).trigger('change');

        // table.clear().draw();
    });

    $('#bookingReportForm').on('submit', function (e) {
        e.preventDefault();

        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();

        $('#fromdate-error').hide().text('');
        $('#todate-error').hide().text('');

        // Perform validation checks
        if (fromDate && toDate) {
            // Check if "From Date" is greater than "To Date"
            if (new Date(fromDate) > new Date(toDate)) {
                $('#fromdate-error').text('From Date cannot be later than To Date').show();
                return false;
            }
        } else if (fromDate || toDate) {
            // Ensure both dates are filled if one is filled
            $('#todate-error').text('Please select both From Date and To Date').show();
            return false;
        }

        table.clear().draw();

        // AJAX request to fetch filtered enquiries
        $.ajax({
            url: '{{ route("bookingreport") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                console.log(response);
                if (response.bookings.length > 0) {
                    $.each(response.bookings, function (index, booking) {
                        let customerName = booking.customer.fname ? (booking.customer.fname + ' ' + booking.customer.lname + '\n' + booking.customer.mobile) : 'N/A';
                        let bookingdate = booking.booking_date;

                        let createdAt = new Date(booking.created_at);
                        let formattedDate = ('0' + createdAt.getDate()).slice(-2) + '-' +
                                            ('0' + (createdAt.getMonth() + 1)).slice(-2) + '-' +
                                            createdAt.getFullYear();

                        // Format time as hh:mm:ss
                        let formattedTime = ('0' + createdAt.getHours()).slice(-2) + ':' +
                                            ('0' + createdAt.getMinutes()).slice(-2) + ':' +
                                            ('0' + createdAt.getSeconds()).slice(-2);

                        let formattedDateTime = formattedDate + ' ' + formattedTime;

                        let acceptedDateTime = 'N/A';

                        if (booking.accepted_at) {
                            let acceptedAt = new Date(booking.accepted_at);
                            let acceptedDate = ('0' + acceptedAt.getDate()).slice(-2) + '-' +
                                            ('0' + (acceptedAt.getMonth() + 1)).slice(-2) + '-' +
                                            acceptedAt.getFullYear();

                            // Format time as hh:mm:ss
                            let acceptedTime = ('0' + acceptedAt.getHours()).slice(-2) + ':' +
                                            ('0' + acceptedAt.getMinutes()).slice(-2) + ':' +
                                            ('0' + acceptedAt.getSeconds()).slice(-2);

                            acceptedDateTime = acceptedDate + ' ' + acceptedTime; // Only set if accepted_at is valid
                        }

                        let addedBy = booking.added_by ? (booking.added_by.first_name + ' ' + booking.added_by.last_name + '\n' + formattedDateTime) : 'N/A';

                        let acceptedBy = booking.accepted_by ? (booking.accepted_by.first_name + ' ' + booking.accepted_by.last_name + '\n' + acceptedDateTime) : 'N/A';
                        // Add rows to the DataTable
                        table.row.add([
                            booking.unique_code,
                            customerName,
                            bookingdate,
                            booking.service.name,  // Services
                            booking.status,
                            booking.payment_status.charAt(0).toUpperCase() + booking.payment_status.slice(1),
                            addedBy,
                            acceptedBy,
                        ]).draw();
                    });
                } else {
                    // Show a message if no enquiries are found
                    // alert('No enquiries found for the selected filters.');
                }
            },
            error: function (xhr) {
                alert('An error occurred. Please try again.');
            }
        });
    });
});


</script>




@endsection
