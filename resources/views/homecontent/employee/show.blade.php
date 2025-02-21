@extends('layout.app')

@section('title', 'Employee Details')

<style>
    .table {
        table-layout: fixed;
        width: 100%;
    }

    .table th,
    .table td {
        width: 25%;
        word-wrap: break-word;
    }

    .badge {
        display: inline-block;
        margin: 2px;
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
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                             Back
                        </a>
                    </div>

                    <!-- Employee Details Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Employee Details</h6>
                        </div>
                        <div class="card-body text-center">
                            <!-- Profile Image -->
                            <div class="mb-4">
                                <img src="{{ asset($employee->profile_image) }}"
                                    class="rounded-circle img-fluid" alt="{{ $employee->first_name . ' ' . $employee->last_name }}"
                                    style="width: 150px; height: 150px;">
                            </div>

                            <!-- Employee Details in Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <!-- Row 1 -->
                                        <tr>
                                            <th>First Name</th>
                                            <td>{{ $employee->first_name ?? 'N/A' }}</td>
                                            <th>Last Name</th>
                                            <td>{{ $employee->last_name ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $employee->mobile ?? 'N/A' }}</td>
                                            <th>WhatsApp</th>
                                            <td>{{ $employee->whatsapp ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Row 3 -->
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $employee->email ?? 'N/A' }}</td>
                                            <th>Departments</th>
                                            <td>
                                                @if ($employee->departments->isEmpty())
                                                    N/A
                                                @else
                                                    @foreach($employee->departments as $department)
                                                        <span class="badge badge-primary">{{ $department->department_name }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Row 4 -->
                                        <tr>
                                            <th>Designation</th>
                                            <td>{{ $employee->designation->designation_name ?? 'N/A' }}</td>
                                            <th>Employee Role</th>
                                            <td>{{ $employee->userRole->name ?? 'N/A' }}</td>
                                        </tr>

                                        <!-- Row 5 -->
                                        <tr>
                                            <th>Miscellaneous</th>
                                            <td colspan="3">{{ $employee->miscellaneous ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
@endsection
