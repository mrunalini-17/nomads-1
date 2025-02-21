@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

    <!-- Popper.js (Version 1.x for Bootstrap 4.x) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- Bootstrap Multiselect CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">

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
                        <h3 class="font-weight-bold text-primary">Create Employee</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary"> <i class="fa-solid fa-backward"></i> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Employee Details</h6>
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col col-6">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="whatsapp" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp">
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="profile_img" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile_img" name="profile_img" accept="image/*">
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>
                                    {{-- <div class="mb-3 col col-6">
                                        <label for="departments" class="form-label">Departments <span class="text-danger">*</span></label>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                aria-expanded="false">
                                                Select Departments
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-multiple"
                                                aria-labelledby="dropdownMenuButton" id="departmentsDropdown">
                                                @foreach ($departments as $department)
                                                    <div class="dropdown-item">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="departments[]" value="{{ $department->id }}"
                                                                id="department-{{ $department->id }}">
                                                            <label class="form-check-label"
                                                                for="department-{{ $department->id }}">
                                                                {{ $department->department_name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="mb-3 col col-6">
                                        <label for="departments" class="form-label">Departments <span class="text-danger">*</span></label>
                                        <select class="form-control form-select" name="departments[]" id="multiple-checkboxes" multiple="multiple">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label for="sub_department_id" class="form-label">Sub Department</label>
                                        <select class="form-control" id="sub_department_id" name="sub_department_id">
                                            <option value="" selected>Select Sub Department</option>
                                            @foreach ($sub_departments as $sub_department)
                                                <option value="{{ $sub_department->id }}">{{ $sub_department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_department_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Designation Dropdown -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="designation_id" class="form-label">Designation <span class="text-danger">*</span></label>
                                        <select class="form-control" id="designation_id" name="designation_id">
                                            <option value="" selected>Select Designation</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}">{{ $designation->designation_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('designation_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- User Role Dropdown -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="user_role_id" class="form-label">User Role <span class="text-danger">*</span></label>
                                        <select class="form-control" id="user_role_id" name="user_role_id">
                                            <option value="" selected>Select User Role</option>
                                            @foreach ($user_roles as $user_role)
                                                <option value="{{ $user_role->id }}">{{ $user_role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_role_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="permissions" class="form-label">Permissions <span class="text-danger">*</span></label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="view"
                                                id="permission_view" name="permissions[]">
                                            <label class="form-check-label" for="permission_view">View</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="edit"
                                                id="permission_edit" name="permissions[]">
                                            <label class="form-check-label" for="permission_edit">Edit</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="update"
                                                id="permission_update" name="permissions[]">
                                            <label class="form-check-label" for="permission_update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="delete"
                                                id="permission_delete" name="permissions[]">
                                            <label class="form-check-label" for="permission_delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="create"
                                                id="permission_create" name="permissions[]">
                                            <label class="form-check-label" for="permission_create">Create</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="miscellaneous" class="form-label">Miscellaneous</label>
                                        <textarea class="form-control" id="miscellaneous" name="miscellaneous"></textarea>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                </div>
                            </form>

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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>





        <!-- Bootstrap Multiselect JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

<!-- Initialize Multiselect -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#multiple-checkboxes').multiselect({
            includeSelectAllOption: true,
            nonSelectedText: 'Select options',
            buttonWidth: '100%'
        });
    });
</script>


    <script>
        function validateImage(input) {
            const file = input.files[0];
            const errorMessage = document.getElementById('error-message');
            if (file) {
                const fileType = file.type;
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(fileType)) {
                    errorMessage.textContent = 'Please select a valid image file (jpg, png, gif).';
                    input.value = '';
                } else {
                    errorMessage.textContent = '';
                }
            }
        }


</script>



@endsection
