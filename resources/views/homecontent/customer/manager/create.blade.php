@extends('layout.app')
@section('title', 'Edit Company')
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
                        <a href="{{ url()->previous() }}" class="btn btn-primary"> <i class="fa-solid fa-backward"></i> Back to view </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Customer</h6>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <form action="{{ route('customer-managers.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="manager_name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="manager_name" name="manager_name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="manager_mobile" class="form-label">Mobile</label>
                                            <input type="text" class="form-control" id="manager_mobile" name="mobile">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="manager_whatsapp" class="form-label">WhatsApp</label>
                                            <input type="text" class="form-control" id="manager_whatsapp" name="whatsapp">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="manager_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="manager_email" name="email">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="manager_position" class="form-label">Position</label>
                                            <input type="text" class="form-control" id="manager_position" name="position">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Manager</button>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            @include('shared.footer')
            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>


@endsection
