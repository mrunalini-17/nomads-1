@extends('layout.app')

@section('title', 'Edit Employee')

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
                            Back</a>
                    </div>

                    <!-- Edit Employee Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Employee Details</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('employees.update', $employee->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- First Name -->
                                    <div class="form-group col-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                            value="{{ old('first_name', $employee->first_name) }}" required>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="form-group col-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control"
                                            value="{{ old('last_name', $employee->last_name) }}">
                                    </div>

                                    <!-- Mobile -->
                                    <div class="form-group col-6">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control"
                                            value="{{ old('mobile', $employee->mobile) }}" oninput="document.getElementById('whatsapp').value = this.value;">
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="form-group col-6">
                                        <label for="whatsapp">WhatsApp</label>
                                        <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                            value="{{ old('whatsapp', $employee->whatsapp) }}">
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="{{ old('email', $employee->email) }}">
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group col-6">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Leave blank to keep current password">
                                    </div>

                                    <!-- Department Dropdown -->
                                    {{-- <div class="form-group col-6">
                                        <label for="departments">Departments</label>
                                        <div class="dropdown">
                                            <button class="btn btn-white border border-1 border-secondary dropdown-toggle"
                                                type="button" id="dropdownDepartments" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Select Departments
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownDepartments">
                                                @foreach ($departments as $department)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="departments[]"
                                                            value="{{ $department->id }}"
                                                            id="department{{ $department->id }}"
                                                            @if (in_array($department->id, old('departments', $employee->departments->pluck('id')->toArray()))) checked @endif>
                                                        <label class="form-check-label"
                                                            for="department{{ $department->id }}">
                                                            {{ $department->department_name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- Display Selected Departments -->
                                        <div class="mt-3">
                                            <strong>Selected Departments:</strong>
                                            <div id="selectedDepartments"></div>
                                        </div>
                                    </div> --}}

                                    <div class="mb-3 col col-6">
                                        <label for="departments" class="form-label">Departments <span class="text-danger">*</span></label>
                                        <select class="form-control" id="departments" name="departments[]" multiple="multiple" required>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                        {{ in_array($department->id, $employee->departments->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Designation -->
                                    <div class="form-group col-6">
                                        <label for="designation_id">Designation</label>
                                        <select name="designation_id" id="designation_id" class="form-control">
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->designation_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- User Role -->
                                    <div class="form-group col-6">
                                        <label for="user_role_id">Employee Role</label>
                                        <select name="user_role_id" id="user_role_id" class="form-control">
                                            @foreach ($userRoles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('user_role_id', $employee->user_role_id) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Profile Image -->
                                    <!-- Profile Image -->
                                    <div class="form-group col-6">
                                        <label for="profile_image">Profile Image</label>

                                        <!-- Display the currently selected image -->
                                        @if ($employee->profile_image)
                                            <div class="mb-2">
                                                <strong>Current Image:</strong> <span
                                                    id="currentImageName">{{ basename($employee->profile_image) }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <img src="{{ asset($employee->profile_image) }}" alt="Profile Image"
                                                    id="currentImagePreview" class="img-thumbnail" width="150">
                                            </div>
                                        @endif

                                        <input type="file" name="profile_image" id="profile_image"
                                            class="form-control" onchange="displaySelectedImageNameAndPreview()">
                                    </div>

                                    <script>
                                        function displaySelectedImageNameAndPreview() {
                                            var input = document.getElementById('profile_image');
                                            var currentImageName = document.getElementById('currentImageName');
                                            var currentImagePreview = document.getElementById('currentImagePreview');

                                            if (input.files && input.files.length > 0) {
                                                currentImageName.innerHTML = input.files[0].name;

                                                // Display the new image preview
                                                var reader = new FileReader();
                                                reader.onload = function(e) {
                                                    currentImagePreview.src = e.target.result;
                                                }
                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                    </script>

                                    <!-- Permissions -->
                                    <!-- Permissions -->
                                    <div class="form-group col col-6">
                                        <label for="permissions">Permissions</label>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="add" id="permissionAdd"
                                                    {{ isset($permissions) && $permissions->add ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permissionAdd">
                                                    Add
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="view" id="permissionView"
                                                    {{ isset($permissions) && $permissions->view ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permissionView">
                                                    View
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="edit" id="permissionEdit"
                                                    {{ isset($permissions) && $permissions->edit ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permissionEdit">
                                                    Edit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="update" id="permissionUpdate"
                                                    {{ isset($permissions) && $permissions->update ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permissionUpdate">
                                                    Update
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="delete" id="permissionDelete"
                                                    {{ isset($permissions) && $permissions->delete ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permissionDelete">
                                                    Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>





                                    <!-- Miscellaneous -->
                                    <div class="form-group col-6">
                                        <label for="miscellaneous">Miscellaneous</label>
                                        <textarea name="miscellaneous" id="miscellaneous" class="form-control">{{ old('miscellaneous', $employee->miscellaneous) }}</textarea>
                                    </div>

                                    <!-- Is Active -->
                                    <div class="form-group col col-6">
                                        <label for="is_active" style="font-weight:bold;">Is Active</label>
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            {{ $employee->is_active ? 'checked' : '' }}>
                                    </div>

                                </div>


                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Update</button>
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

    <script>
        // $(document).ready(function() {
        //     // Function to update the selected departments display
        //     function updateSelectedDepartments() {
        //         let selectedDepartments = [];
        //         $("input[name='departments[]']:checked").each(function() {
        //             selectedDepartments.push($(this).next('label').text());
        //         });
        //         $('#selectedDepartments').html(selectedDepartments.join(', '));
        //     }

        //     // Event listener for checkbox changes
        //     $("input[name='departments[]']").change(function() {
        //         updateSelectedDepartments();
        //     });

        //     // Initial update on page load
        //     updateSelectedDepartments();
        // });

        $(document).ready(function() {
                $('#departments').select2({
                    placeholder: 'Select department(s)',
                    allowClear: true,
                    width: '100%'
                });

            });
    </script>
@endsection
