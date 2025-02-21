@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

<style>
    .truncate-note {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    max-height: 3em;
}

</style>
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
                        <h3 class="font-weight-bold text-primary">Enquiry List</h3>
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
                                            {{-- <th>Mobile</th> --}}
                                            <th>Service</th>
                                            <th>Notes</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            {{-- <th>Date</th> --}}
                                            <th>Added by</th>
                                            <th>Accepted by</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>



                                    <tbody>
                                        @foreach ($enquiries as $enquiry)
                                            <tr class="{{ $enquiry->is_transferred ? 'table-warning' : '' }}">
                                                <td>{{ $enquiry->unique_code }}</td>
                                                <td>{{ $enquiry->fname }} {{ $enquiry->lname }}<br>{{ $enquiry->mobile }}</td>
                                                {{-- <td>{{ $enquiry->mobile }}</td> --}}
                                                <td>
                                                    @foreach ($enquiry->services as $service)
                                                        {{ $service->name }}<br>
                                                    @endforeach
                                                </td>
                                                {{-- <td><div class="truncate-note">{{ $enquiry->note }}</div></td> --}}
                                                <td>{{ $enquiry->note }}</td>
                                                <td>{{ $enquiry->priority }}</td>
                                                <td>{{ $enquiry->status }}</td>
                                                {{-- <td>{{ \Carbon\Carbon::parse($enquiry->created_at)->format('d-m-Y') }}</td> --}}
                                                <td>
                                                    @if ($enquiry->addedBy)
                                                        {{ $enquiry->addedBy->first_name ?? 'N/A' }} {{ $enquiry->addedBy->last_name ?? 'N/A' }}
                                                        <br>
                                                        <small>{{ $enquiry->created_at ? $enquiry->created_at->format('d-m-Y') : 'N/A' }}</small>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="{{ $enquiry->accepted_by ? 'text-success' : 'text-center' }}">
                                                    @if ($enquiry->is_accepted == 0)
                                                        --
                                                    @elseif ($enquiry->is_accepted == 1 && $enquiry->acceptedBy)
                                                        {{ optional($enquiry->acceptedBy)->first_name . ' ' . optional($enquiry->acceptedBy)->last_name }}
                                                        <br>
                                                        <small>{{ $enquiry->accepted_at ? $enquiry->accepted_at->format('d-m-Y') : 'N/A' }}</small>
                                                    @else
                                                        --
                                                    @endif
                                                </td>



                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton{{ $enquiry->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $enquiry->id }}">
                                                                <li>
                                                                    {{-- <a class="dropdown-item text-success view-enq-btn" href="javascript:void(0);" data-enq-id={{ $enquiry->id }}>

                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a> --}}
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
                                                                <li>
                                                                    <form action="{{ route('enquiries.destroy', $enquiry->id) }}"
                                                                          method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger"
                                                                                onclick="return confirm('Are you sure you want to delete this enquiry?');">
                                                                            <i class="fa-solid fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
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

            @include('shared.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

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
                                    <tr>
                                        <th>Accepted by</th>
                                        <td id="accepted_by"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <div class="w-100 text-center">
                                    <button type="button" id="edit_button" class="btn btn-primary edit">Edit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script>
        $(document).ready(function() {
            // Listen for clicks on the view button
            $('.view-enq-btn').on('click', function() {
                var enquiryId = $(this).data('enq-id');

                // Make an AJAX call to fetch enquiry details
                $.ajax({
                    url: '/edit_enquiry/' + enquiryId,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        // Populate the modal with the returned data
                        let name = response.fname +' '+response.lname;
                        $('#view_name').text(name);
                        $('#view_whatsapp').text(response.whatsapp ? response.whatsapp : 'N/A');
                        $('#view_mobile').text(response.mobile ? response.mobile : 'N/A');
                        $('#view_email').text(response.email ? response.email : 'N/A');
                        $('#view_address').text(response.address ? response.address : 'N/A');
                        $('#view_priority').text(response.priority ? response.priority : 'N/A');
                        $('#view_note').text(response.note ? response.note : 'N/A');
                        $('#view_assignedTo').text(response.note ? response.note : 'N/A');
                        $('#added_by').text(response.added_by ? response.added_by.first_name +' '+ response.added_by.last_name: 'N/A');
                        $('#accepted_by').text(response.accepted_by ? response.accepted_by.first_name +' '+ response.accepted_by.last_name: 'N/A');
                        $('#edit_button').attr('data-enquiry-id', response.id);

                        $('#view_service').empty();

                        if (response.services && response.services.length > 0) {
                            $.each(response.services, function(index, service) {
                                $('#view_service').append('<span>' + service.name + '</span><br>');
                            });
                        } else {
                            $('#view_service').text('N/A');
                        }
                        // Show the modal
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
        $(document).on('click', '.edit', function() {
            var enquiryId = $(this).data('enquiry-id');
                window.location.href = 'enquiries/'+ enquiryId + '/edit' ;
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
