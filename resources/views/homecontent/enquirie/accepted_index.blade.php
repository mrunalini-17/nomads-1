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
                        <h3 class="font-weight-bold text-primary">Accepted Enquiry List</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
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
                                            @cannot('operations')<th>Accepted by</th>@endcannot
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
                                                <td class="text-success">{{ $enquiry->status }}</td>
                                                <td>
                                                    @if ($enquiry->addedBy)
                                                        {{ $enquiry->addedBy->first_name ?? 'N/A' }} {{ $enquiry->addedBy->last_name ?? 'N/A' }}
                                                        <br>
                                                        <small>{{ $enquiry->created_at ? $enquiry->created_at->format('d-m-Y') : 'N/A' }}</small>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                @cannot('operations')
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
                                                @endcannot
                                                <td>
                                                    <div class="text-left">

                                                        <a class="button text-success mx-1" href="{{ route('update_accepted', $enquiry->id) }}">
                                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                                        </a>
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

                {{-- <!-- Update Enquiry Status Modal -->
                <div class="modal fade" id="viewEnquiryModal" tabindex="-1" aria-labelledby="viewEnquiryLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="update_enq_status">
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
                                        <th>Update Status</th>
                                        <td id="change_status">
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Converted">Converted</option>
                                                <option value="Dead">Dead</option>
                                            </select>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="submit" class="btn btn-success submitted">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div> --}}

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
