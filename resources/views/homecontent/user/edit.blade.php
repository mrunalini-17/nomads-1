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
                    <div class="py-3 px-2">
                        <h3 class="font-weight-bold text-primary">Edit Employee</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary"> <i class="fa-solid fa-backward"></i> Back
                            to view </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Employee</h6>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('user.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ $user->first_name }}" required>
                                        @error('first_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ $user->last_name }}" required>
                                        @error('last_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="mobile" class="form-label">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            value="{{ $user->mobile }}" required>
                                        @error('mobile')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="whatsapp" class="form-label">WhatsApp</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                            value="{{ $user->whatsapp }}">
                                        @error('whatsapp')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" required>
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Department Dropdown -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="department_id" class="form-label">Department</label>
                                        <select class="form-control" id="department_id" name="department_id">
                                            <option value="" selected>Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Sub Department Dropdown -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="sub_department_id" class="form-label">Sub Department</label>
                                        <select class="form-control" id="sub_department_id" name="sub_department_id">
                                            <option value="" selected>Select Sub Department</option>
                                            @foreach ($sub_departments as $sub_department)
                                                <option value="{{ $sub_department->id }}"
                                                    {{ $user->sub_department_id == $sub_department->id ? 'selected' : '' }}>
                                                    {{ $sub_department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_department_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Designation Dropdown -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="designation_id" class="form-label">Designation</label>
                                        <select class="form-control" id="designation_id" name="designation_id">
                                            <option value="" selected>Select Designation</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ $user->designation_id == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->designation_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('designation_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- User Role Dropdown -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="user_role_id" class="form-label">User Role</label>
                                        <select class="form-control" id="user_role_id" name="user_role_id">
                                            <option value="" selected>Select User Role</option>
                                            @foreach ($user_roles as $user_role)
                                                <option value="{{ $user_role->id }}"
                                                    {{ $user->user_role_id == $user_role->id ? 'selected' : '' }}>
                                                    {{ $user_role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_role_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Miscellaneous -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="miscellaneous" class="form-label">Miscellaneous</label>
                                        <textarea class="form-control" id="miscellaneous" name="miscellaneous">{{ $user->miscellaneous }}</textarea>
                                        @error('miscellaneous')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right"> <button type="submit" class="btn btn-primary">Update
                                        User</button></div>
                            </form>


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
