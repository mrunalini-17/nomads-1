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
                        <h3 class="font-weight-bold text-primary">Employee List</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="text-right mb-3"><a class="btn btn-sm btn-primary"
                                    href="{{ route('employees.create') }}">Add Employee</a></div>
                            <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $employee->first_name && $employee->last_name ? $employee->first_name . ' ' . $employee->last_name : 'N/A' }}
                                            </td>
                                            <td>{{ $employee->email ?: 'N/A' }}</td>
                                            <td>{{ $employee->mobile ?: 'N/A' }}</td>
                                            <td>{{ $employee->userRole ? $employee->userRole->name : 'N/A' }}</td>
                                            <td>
                                                <div class="text-center">
                                                    <!-- Dropdown button -->
                                                    <div class="dropdown">
                                                        <button class="text-info border-0 bg-transparent dropdown-toggle"
                                                            type="button" id="dropdownMenuButton{{ $employee->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $employee->id }}">
                                                            <li>
                                                                <a class="dropdown-item text-success"
                                                                    href="{{ route('employees.show', $employee->id) }}">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-warning"
                                                                    href="{{ route('employees.edit', $employee->id) }}">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-primary" data-bs-toggle="modal"
                                                                    data-bs-target="#changePasswordModal{{ $employee->id }}">
                                                                    <i class="fa-solid fa-key"></i> Change Password
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('employees.destroy', $employee->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this employee?');">
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

                            <!-- Change Password Modal -->
                            @foreach ($employees as $employee)
                                <div class="modal fade" id="changePasswordModal{{ $employee->id }}" tabindex="-1"
                                    aria-labelledby="changePasswordModalLabel{{ $employee->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title m-0 font-weight-bold text-primary"
                                                    id="changePasswordModalLabel{{ $employee->id }}">Change Password</h6>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('employees.updatePassword', $employee->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="row">
                                                        <!-- New Password Field -->
                                                        <div class="mb-3 col-12">
                                                            <label for="newPassword{{ $employee->id }}"
                                                                class="form-label">New Password</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    id="newPassword{{ $employee->id }}" name="password"
                                                                    required>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button"
                                                                        id="toggleNewPassword{{ $employee->id }}">
                                                                        <i class="fa fa-eye"
                                                                            id="eyeIconNew{{ $employee->id }}"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Confirm New Password Field -->
                                                        <div class="mb-3 col-12">
                                                            <label for="confirmPassword{{ $employee->id }}"
                                                                class="form-label">Confirm New Password</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    id="confirmPassword{{ $employee->id }}"
                                                                    name="password_confirmation" required>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button"
                                                                        id="toggleConfirmPassword{{ $employee->id }}">
                                                                        <i class="fa fa-eye"
                                                                            id="eyeIconConfirm{{ $employee->id }}"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Save changes</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
              <!-- Footer -->
    @include('shared.footer')
    <!-- End of Footer -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->



    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle visibility for new password
            document.querySelectorAll('[id^="toggleNewPassword"]').forEach(button => {
                button.addEventListener('click', function() {
                    const passwordField = document.querySelector(
                        `#${this.id.replace('toggleNewPassword', 'newPassword')}`);
                    const eyeIcon = document.querySelector(
                        `#${this.id.replace('toggleNewPassword', 'eyeIconNew')}`);

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    } else {
                        passwordField.type = 'password';
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    }
                });
            });

            // Toggle visibility for confirm password
            document.querySelectorAll('[id^="toggleConfirmPassword"]').forEach(button => {
                button.addEventListener('click', function() {
                    const passwordField = document.querySelector(
                        `#${this.id.replace('toggleConfirmPassword', 'confirmPassword')}`);
                    const eyeIcon = document.querySelector(
                        `#${this.id.replace('toggleConfirmPassword', 'eyeIconConfirm')}`);

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    } else {
                        passwordField.type = 'password';
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>


@endsection
