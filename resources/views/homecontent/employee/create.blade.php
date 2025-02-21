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
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">x</button>
                        </div>
                    @endif
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back
                        </a>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Employee Details</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="form-group col col-6">
                                        <label for="first_name">First Name <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="form-group col col-6">
                                        <label for="last_name">Last Name <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <!-- Mobile -->
                                    <div class="form-group col col-6">
                                        <label for="mobile">Mobile <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="tel" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                            value="{{ old('mobile') }}" pattern="[0-9]{10}" required oninput="document.getElementById('whatsapp').value = this.value;">
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="form-group col col-6">
                                        <label for="whatsapp">WhatsApp <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="" name="whatsapp" id="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                                            value="{{ old('whatsapp') }}" pattern="[0-9]{10}" required>
                                        @error('whatsapp')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group col col-6">
                                        <label for="email">Email <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group col col-6">
                                        <label for="password">Password <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    {{-- <!-- Department Dropdown -->
                                    <div class="form-group col col-6">
                                        <label for="departments">Departments <span class="text-danger"><sup>*</sup></span></label>
                                        <div class="dropdown">
                                            <button class="btn btn-white broder border-1 broder-secondary dropdown-toggle" type="button"
                                                id="dropdownDepartments" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Select Departments
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownDepartments">
                                                @foreach ($departments as $department)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="departments[]"
                                                            value="{{ $department->id }}"
                                                            id="department{{ $department->id }}">
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

                                    <!-- Department  multiselect-->
                                    <div class="mb-3 col col-6">
                                        <label for="departments" class="form-label">Departments <span class="text-danger">*</span></label>
                                        <div class="col" style="padding:0px;">
                                            <select name="departments[]" id="departments" class="form-control" multiple="multiple" required>
                                                <option value="" disable>Select department(s)</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <!-- Designation -->
                                    <div class="form-group col col-6">
                                        <label for="designation_id">Designation <span class="text-danger"><sup>*</sup></span></label>
                                        <select name="designation_id" id="designation_id" class="form-control">
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->designation_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- User Role -->
                                    <div class="form-group col col-6">
                                        <label for="user_role_id">Employee Role <span class="text-danger"><sup>*</sup></span></label>
                                        <select name="user_role_id" id="user_role_id" class="form-control" required>
                                            @foreach ($userRoles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('user_role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Profile Image -->
                                    <div class="form-group col col-6">
                                        <label for="profile_image">Profile Image</label>
                                        <input type="file" name="profile_image" id="profile_image"
                                            class="form-control">
                                    </div>

                                    <!-- Permissions -->
                                    <div class="form-group col col-6">
                                        <label for="permissions">Permissions <span class="text-danger"><sup>*</sup></span></label>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="add" id="permissionAdd">
                                                <label class="form-check-label" for="permissionAdd">
                                                    Add
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="view" id="permissionView">
                                                <label class="form-check-label" for="permissionView">
                                                    View
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="edit" id="permissionEdit">
                                                <label class="form-check-label" for="permissionEdit">
                                                    Edit
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="update" id="permissionUpdate">
                                                <label class="form-check-label" for="permissionUpdate">
                                                    Update
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="delete" id="permissionDelete">
                                                <label class="form-check-label" for="permissionDelete">
                                                    Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Is Active -->
                                    {{-- <div class="form-group col col-6">
                                        <label for="is_active">Is Active</label>
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            {{ old('is_active') ? 'checked' : '' }} required>
                                    </div> --}}

                                    <!-- Miscellaneous -->
                                    <div class="form-group col col-6">
                                        <label for="miscellaneous">Miscellaneous</label>
                                        <textarea name="miscellaneous" id="miscellaneous" class="form-control">{{ old('miscellaneous') }}</textarea>
                                    </div>
                                </div>



                        </div>

                        <div class="card-footer">
                            <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button></div>
                        </div>
                    </form>
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


    <!-- End of Page Wrapper -->
    <script>
            $(document).ready(function() {
                $('#departments').select2({
                    placeholder: 'Select department(s)',
                    allowClear: true,
                    width: '100%'
                });

            });


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
    </script>
@endsection
