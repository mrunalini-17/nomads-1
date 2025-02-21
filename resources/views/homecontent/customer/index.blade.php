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
                        <h3 class="font-weight-bold text-primary">Customer List</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
                        </div> --}}
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <input type="text" id="customer-search" class="form-control me-2" placeholder="Search customers..." style="max-width: 400px;" />
                                <a class="btn btn-sm btn-primary" href="{{route('customers.create')}}">Add Customer</a>
                            </div>

                            <div class="table-responsive">
                                {{-- <table class="table table-bordered table-striped" id="dataTable" cellspacing="0"> --}}
                                <table class="table table-bordered table-striped" id="customers-dataTable" cellspacing="0" style="font-size: 14px;">
                                       <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr no</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Whatsapp</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Reference</th>
                                            <th>Has Manager</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customers-table-body">
                                        @include('homecontent.customer.partials.table', ['customers' => $customers])
                                    </tbody>
                                </table>
                            </div>
                            <div id="pagination-links">
                                {{ $customers->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
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

    <!-- Logout Modal-->
    {{-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
    </div> --}}
{{-- @foreach ($customers as $customer)
    <!-- Modal -->
    <div class="modal fade" id="viewModal{{ $customer->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $customer->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel{{ $customer->id }}">Customer Details</h5>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $customer->mobile }}</td>
                        </tr>
                        <tr>
                            <th>WhatsApp</th>
                            <td>{{ $customer->whatsapp }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $customer->address }}</td>
                        </tr>
                        <tr>
                            <th>Service</th>
                            <td>{{ $customer->service->service_name ?? 'NA' }}</td>
                        </tr>
                        <tr>
                            <th>Has Manager</th>
                            <td>{{ $customer->have_manager ? 'Yes' : 'No' }}</td>
                        </tr>
                        @if($customer->have_manager)
                            <tr>
                                <th>Manager Name</th>
                                <td>{{ $customer->manager_name ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Manager Mobile</th>
                                <td>{{ $customer->manager_mobile ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Manager WhatsApp</th>
                                <td>{{ $customer->manager_whatsapp ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Manager Email</th>
                                <td>{{ $customer->manager_email ?? 'NA' }}</td>
                            </tr>
                            <tr>
                                <th>Manager Position</th>
                                <td>{{ $customer->manager_position ?? 'NA' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Added By</th>
                            <td>{{ optional($customer->addedBy)->first_name ?? 'NA' }} {{ optional($customer->addedBy)->last_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Updated By</th>
                            <td>{{ optional($customer->updatedBy)->first_name ?? 'NA' }} {{ optional($customer->updatedBy)->last_name ?? '' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
@endforeach --}}


<script>
$(document).ready(function () {
    $('#customer-search').on('input', function () {
        const searchQuery = $(this).val();
        $.ajax({
            url: "{{ route('customers.index') }}",
            method: 'GET',
            data: { search: searchQuery },
            success: function (response) {
                $('#customers-table-body').html(response.view);
                $('#pagination-links').html(response.pagination);
            },
            error: function () {
                alert('Failed to fetch customers. Please try again.');
            }
        });
    });
});

</script>



@endsection
