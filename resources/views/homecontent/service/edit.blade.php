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
                        <h3 class="font-weight-bold text-primary">Edit Service</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Service Details</h6>
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('services.update', $service->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Service Name Field -->
                                    <div class="form-group col-md-12 mb-3">
                                        <label for="name" class="form-label">Service Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" required>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description">{{ $service->description }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label for="is_active" class="form-label">Status</label>
                                        <select name="is_active" id="is_active" class="form-control" required>
                                            <option value="1" {{ $service->is_active == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $service->is_active == 0 ? 'selected' : '' }}>In-active</option>
                                        </select>
                                        @error('is_active')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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



@endsection
