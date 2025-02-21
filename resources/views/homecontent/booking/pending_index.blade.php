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
                        <h3 class="font-weight-bold text-primary">Pending Bookings List</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <input type="text" id="booking-search" class="form-control me-2" placeholder="Search bookings..." style="max-width: 400px;" />
                                {{-- <a class="btn btn-sm btn-primary" href="{{ route('bookings.create') }}">Create booking</a> --}}
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable1" cellspacing="0" style="font-size: 14px;">
                                    <thead class="bg-light text-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            {{-- <th>Manager</th> --}}
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Added By</th>
                                            <th>Accepted By</th>
                                            <th>Updated By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="booking-table-body">
                                        @include('homecontent.booking.partials.pending_booking_table', ['bookings' => $bookings])
                                    </tbody>
                                </table>
                                <div id="pagination-links">
                                    {{ $bookings->links('pagination::bootstrap-5') }}
                                </div>
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


<script>
    $(document).ready(function () {
        $('#booking-search').on('input', function () {
            const searchQuery = $(this).val();
            $.ajax({
                url: "{{ route('bookings.pending_index') }}",
                method: 'GET',
                data: { search: searchQuery },
                success: function (response) {
                    $('#booking-table-body').html(response.view);
                    $('#pagination-links').html(response.bookings.links);
                },
                error: function () {
                    alert('Failed to fetch bookings. Please try again.');
                }
            });
        });
    });

</script>

@endsection
