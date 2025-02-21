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
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Attendance Details</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <th>Mobile</th>
                                    <td>{{ $user->mobile }}</td>
                                </tr>

                                <tr>
                                    <th>Whatsapp</th>
                                    <td>{{ $user->whatsapp }}</td>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>

                                <tr>
                                    <th>Permissions</th>
                                    <td>
                                        @if ($user->permissions)
                                            @foreach (json_decode($user->permissions) as $permission)
                                                <span class="badge bg-secondary text-white">{{ $permission }}</span>
                                            @endforeach
                                        @else
                                            No permissions
                                        @endif
                                    </td>
                                </tr>
                                <!-- Add other user details here -->
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
