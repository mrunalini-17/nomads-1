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
                    <div class=" py-3 px-2">
                        <h3 class=" font-weight-bold text-primary">Notification List</h3>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Notification Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-right p-2 mb-3 ">
                                {{-- <a href="{{route('notifications.create')}}" class="btn btn-primary btn-sm"> Add Notification </a> --}}
                            </div>
                            <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                     <thead class="bg-light text-dark">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Type</th>
                                        <th>Recievers</th>
                                        <th>Message</th>
                                        <th>Read by</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucfirst($notification->type) }}</td>
                                            <td>
                                                {{ $notification->employees->pluck('full_name')->implode(', ') }}
                                            </td>
                                            <td>{{ $notification->message }}</td>
                                            <td>{{ $notification->read_by_employees->pluck('full_name')->implode(', ') }}</td>
                                            <td>{{ $notification->created_at->format('d-m-Y H:i') }}</td>
                                            <td>
                                                <!-- Actions column -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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



@endsection
