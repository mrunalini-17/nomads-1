@extends('layout.app')
@section('title', 'Enquiry Reports')

<style>
    div .dt-buttons{
        margin-bottom: 8px;
    }

    .dataTables_wrapper .dataTable {
        white-space: pre-wrap;
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
                        <h3 class="font-weight-bold text-primary">Enquiry Reports</h3>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="filters">
                                <form action="{{ route('operationsenquiryreport')}}" id="enquiryReportForm" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="customer">Search Customer</label>
                                                <input type="text" name="customer" id="customer" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="form-group">
                                                <label for="customer">Search Enquiry ID</label>
                                                <input type="text" name="unique_code" id="unique_code" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="services" class="form-label">Select Services </label>
                                            <select name="services[]" id="services" class="select2 form-control" multiple="multiple">
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="sources" class="form-label">Select Sources </label>
                                            <select name="sources" id="sources" class="select2 form-control">
                                                <option value="" disable>Select</option>
                                                @foreach ($sources as $source)
                                                    <option value="{{ $source->id }}">{{ $source->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="priority" class="form-label">Priority</label>
                                            <select class="form-control" id="priority" name="priority">
                                                <option value="" disable>Select</option>
                                                <option value="Corporate">Corporate</option>
                                                <option value="Urgent">Urgent (travel within 48Hrs)</option>
                                                <option value="High">High</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Low">Low</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="" disable>Select</option>
                                                <option value="New">New</option>
                                                <option value="Active">Active</option>
                                                <option value="Converted">Converted</option>
                                                <option value="Dead">Dead</option>
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
    <table class="table table-bordered table-striped" id="enquiryTable" cellspacing="0">
        <thead class="bg-light text-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Service</th>
                <th>Source</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Added by</th>
                <th>Accepted by</th>
            </tr>
        </thead>
        <tbody id="enquiryTableBody">
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
    var table = $('#enquiryTable').DataTable({
        dom: 'Bfrtip',
        searching: false,
        buttons: [
            {
            extend: 'excelHtml5',
            text: 'Excel',
            title: 'Enquiry Report',
            className: 'btn btn-primary'
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'Enquiry Report',
            orientation: 'landscape',
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
        $('#enquiryReportForm')[0].reset();

        $('.select2').val(null).trigger('change');

        // table.clear().draw();
    });

    $('#enquiryReportForm').on('submit', function (e) {
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
            url: '{{ route("operationsenquiryreport") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                console.log(response);
                if (response.enquiries.length > 0) {
                    $.each(response.enquiries, function (index, enquiry) {
                        let customerName = enquiry.fname ? (enquiry.fname + ' ' + enquiry.lname) : 'N/A';
                        let createdAt = new Date(enquiry.created_at);
                        let formattedDate = ('0' + createdAt.getDate()).slice(-2) + '-' +
                                            ('0' + (createdAt.getMonth() + 1)).slice(-2) + '-' +
                                            createdAt.getFullYear();

                        // Format time as hh:mm:ss
                        let formattedTime = ('0' + createdAt.getHours()).slice(-2) + ':' +
                                            ('0' + createdAt.getMinutes()).slice(-2) + ':' +
                                            ('0' + createdAt.getSeconds()).slice(-2);

                        let formattedDateTime = formattedDate + ' ' + formattedTime;

                        let acceptedAt = new Date(enquiry.accepted_at);
                        let acceptedDate = ('0' + acceptedAt.getDate()).slice(-2) + '-' +
                                            ('0' + (acceptedAt.getMonth() + 1)).slice(-2) + '-' +
                                            acceptedAt.getFullYear();

                        // Format time as hh:mm:ss
                        let acceptedTime = ('0' + acceptedAt.getHours()).slice(-2) + ':' +
                                            ('0' + acceptedAt.getMinutes()).slice(-2) + ':' +
                                            ('0' + acceptedAt.getSeconds()).slice(-2);

                        let acceptedDateTime = acceptedDate + ' ' + acceptedTime;

                        let addedBy = enquiry.added_by ? (enquiry.added_by.first_name + ' ' + enquiry.added_by.last_name + '\n' + formattedDateTime) : 'N/A';

                        let acceptedBy = enquiry.accepted_by ? (enquiry.accepted_by.first_name + ' ' + enquiry.accepted_by.last_name + '\n' + acceptedDateTime) : 'N/A';

                        // Add rows to the DataTable
                        table.row.add([
                            enquiry.unique_code,
                            customerName,
                            enquiry.mobile,
                            enquiry.services.map(service => service.name).join(', '),  // Services
                            enquiry.source.title,
                            enquiry.priority.charAt(0).toUpperCase() + enquiry.priority.slice(1),  // Priority
                            enquiry.status,
                            addedBy,
                            acceptedBy,
                            formattedDate
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
