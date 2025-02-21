@extends('layout.app')

@section('title', 'Employee Profile')

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
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back</a>
                    </div>
                    <div class="row">
                        <!-- Profile Card -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Profile</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ $employee->profile_image ? asset($employee->profile_image) : asset('assets/img/undraw_profile.svg') }}"
                                        alt="Profile Image" class="img-profile rounded-circle"
                                        style="width: 150px; height: 150px;">
                                    <h4 class="mt-3">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                                    <p class="text-muted">{{ $employee->userRole ? $employee->userRole->name : 'No Role Assigned' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Personal Details</h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-3">Email:</dt>
                                        <dd class="col-sm-9">{{ $employee->email }}</dd>

                                        <dt class="col-sm-3">Mobile:</dt>
                                        <dd class="col-sm-9">{{ $employee->mobile }}</dd>

                                        <dt class="col-sm-3">WhatsApp:</dt>
                                        <dd class="col-sm-9">{{ $employee->whatsapp }}</dd>

                                        <dt class="col-sm-3">Departments:</dt>
                                        <dd class="col-sm-9">
                                            @if ($employee->departments->isNotEmpty())
                                                <ul>
                                                    @foreach ($employee->departments as $department)
                                                        <li>{{ $department->department_name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                No Departments Assigned
                                            @endif
                                        </dd>

                                        <dt class="col-sm-3">Designation:</dt>
                                        <dd class="col-sm-9">
                                            {{ $employee->designation ? $employee->designation->designation_name : 'Not Assigned' }}
                                        </dd>

                                        <dt class="col-sm-3">Miscellaneous:</dt>
                                        <dd class="col-sm-9">{{ $employee->miscellaneous }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Change Password Trigger -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal{{ $employee->id }}">
                            <i class="fa-solid fa-key"></i> Change Password
                        </a>
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

    <!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal{{ $employee->id }}" tabindex="-1"
    aria-labelledby="changePasswordModalLabel{{ $employee->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0 font-weight-bold text-primary"
                    id="changePasswordModalLabel{{ $employee->id }}">Change Password</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.updatePassword', $employee->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="newPassword{{ $employee->id }}" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword{{ $employee->id }}" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword{{ $employee->id }}', 'eyeIconNew{{ $employee->id }}')">
                                <i class="fa fa-eye" id="eyeIconNew{{ $employee->id }}"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Confirm New Password -->
                    <div class="mb-3">
                        <label for="confirmPassword{{ $employee->id }}" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword{{ $employee->id }}" name="password_confirmation" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword{{ $employee->id }}', 'eyeIconConfirm{{ $employee->id }}')">
                                <i class="fa fa-eye" id="eyeIconConfirm{{ $employee->id }}"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



<script>
    function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

</script>
