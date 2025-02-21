@extends('layout.app')
@section('title', 'Designation')
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
                        <a href="{{ url()->previous() }}" class="btn btn-primary"> <i class="fa-solid fa-backward"></i> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Designation</h6>
                        </div>
                        <form id="designationForm" action="{{ route('designation.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="table-responsive">
                                        <div class="mb-3">
                                            <label for="designation_name" class="form-label">Designation Name</label>
                                            <input type="text" class="form-control" id="designation_name" name="designation_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Submit</button>
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

    <script>
        document.getElementById('departmentForm').addEventListener('submit', function(event) {

            var designationName = document.getElementById('designation_name').value.trim();
            var description = document.getElementById('description').value.trim();

            // Validate designation Name
            if (designationName === '') {
                alert('Designation Name is required');
                event.preventDefault();
                return false;
            }
            return true;
        });
    </script>




@endsection
