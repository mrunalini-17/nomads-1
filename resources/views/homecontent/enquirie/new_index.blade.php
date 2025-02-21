@extends('layout.app')
@section('title', 'Dashboard')
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
                        <h3 class="font-weight-bold text-primary">New Enquiries List</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="text-right mb-3"><a class="btn btn-sm btn-primary" href="{{route('enquiries.create')}}">Add Enquiry</a></div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                       <thead class="bg-light text-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name & Mobile</th>
                                            <th>Service</th>
                                            <th>Notes</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Added by</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach ($enquiries as $enquiry)
                                            <tr class="{{ $enquiry->is_transferred ? 'table-warning' : '' }}">
                                                <td>{{ $enquiry->unique_code }}</td>
                                                <td>{{ $enquiry->fname }} {{ $enquiry->lname }}<br>{{ $enquiry->mobile }}</td>

                                                <td>
                                                    @foreach ($enquiry->services as $service)
                                                        {{ $service->name }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $enquiry->note }}</td>
                                                <td>{{ $enquiry->priority }}</td>
                                                <td>{{ $enquiry->status }}</td>
                                                <td>
                                                    @if ($enquiry->addedBy)
                                                        {{ $enquiry->addedBy->first_name ?? 'N/A' }} {{ $enquiry->addedBy->last_name ?? 'N/A' }}
                                                        <br>
                                                        <small>{{ $enquiry->created_at ? $enquiry->created_at->format('d-m-Y') : 'N/A' }}</small>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        {{--<a class="button text-success mx-1 view-enq-btn" href="javascript:void(0);" data-enq-id={{ $enquiry->id }}>
                                                        <i class="fa-solid fa-eye"></i> View
                                                        </a> --}}

                                                        <a class="button text-success mx-1" href="{{ route('show_enquiries.index', $enquiry->id) }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </a>

                                                        <!-- Dropdown button -->
                                                        {{-- <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton{{ $enquiry->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $enquiry->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-success" href="{{ route('show_enquiries.index', $enquiry->id) }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-primary"
                                                                       href="{{ route('enquiries.edit', $enquiry->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- View Enquiry Modal -->
            <div class="modal fade" id="viewEnquiryModal" tabindex="-1" aria-labelledby="viewEnquiryLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewEnquiryLabel">View Enquiry</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <td id="view_name"></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td id="view_mobile"></td>
                                </tr>

                                <tr>
                                    <th>Whatsapp</th>
                                    <td id="view_whatsapp"></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="view_email"></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td id="view_address"></td>
                                </tr>
                                <tr>
                                    <th>Services</th>
                                    <td id="view_service"></td>
                                </tr>
                                <tr>
                                    <th>Priority</th>
                                    <td id="view_priority"></td>
                                </tr>
                                <tr>
                                    <th>Notes</th>
                                    <td id="view_note"></td>
                                </tr>
                                <tr>
                                    <th>Added by</th>
                                    <td id="added_by"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="accept_button" class="btn btn-success accepted">Accept</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


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
        $('.view-enq-btn').on('click', function() {
            var enquiryId = $(this).data('enq-id');

            $.ajax({
                url: '/edit_enquiry/' + enquiryId,
                method: 'GET',
                success: function(response) {
                    let name = response.fname +' '+response.lname;
                    $('#view_name').text(name);
                    $('#view_whatsapp').text(response.whatsapp ? response.whatsapp : 'N/A');
                    $('#view_mobile').text(response.mobile ? response.mobile : 'N/A');
                    $('#view_email').text(response.email ? response.email : 'N/A');
                    $('#view_address').text(response.address ? response.address : 'N/A');
                    $('#view_priority').text(response.priority ? response.priority : 'N/A');
                    $('#view_note').text(response.note ? response.note : 'N/A');
                    $('#added_by').text(response.added_by ? response.added_by.first_name +' '+ response.added_by.last_name: 'N/A');
                    $('#accept_button').attr('data-enquiry-id', response.id);


                    $('#view_service').empty();

                    if (response.services && response.services.length > 0) {
                        $.each(response.services, function(index, service) {
                            $('#view_service').append('<span>' + service.name + '</span><br>');
                        });
                    } else {
                        $('#view_service').text('N/A');
                    }


                    $('#viewEnquiryModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.error("Error fetching enquiry details: " + error);
                }
            });
        });
    });


    //accept the enquiry
    $(document).on('click', '.accepted', function() {
        var enquiryId = $(this).data('enquiry-id'); // Get the enquiry ID from the button

        // Show confirmation dialog
        var confirmation = confirm("Are you sure you want to accept this enquiry?");

        if (confirmation) {
            // If confirmed, redirect to the accept route
            window.location.href = '/accept_enquiry/' + enquiryId;
        }
    });


</script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[0, 'desc']],
            responsive: true,
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>




@endsection
