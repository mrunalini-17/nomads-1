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
                        <h3 class="font-weight-bold text-primary">Edit Sub-Department</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary"> <i class="fa-solid fa-backward"></i> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Sub-department</h6>
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('subdepartment.update', $subdepartment->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Department Selection -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="department_id" class="form-label">Department</label>
                                        <select class="form-control" id="department_id" name="department_id" required>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" {{ $subdepartment->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subdepartment Name -->
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="name" class="form-label">Subdepartment Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $subdepartment->name }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
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



@endsection
