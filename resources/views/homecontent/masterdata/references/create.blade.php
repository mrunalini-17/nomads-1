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
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary"> <i class="fa-solid fa-backward"></i> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Card Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ route('cards.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="card_name" class="form-label">Card Name</label>
                                        <input type="text" class="form-control" id="card_name"
                                            name="card_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="card_number" class="form-label">Card Number</label>
                                        <input type="number" class="form-control" id="card_number"
                                            name="card_number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        {{-- <input type="date" class="form-control" id="expiry_date"
                                            name="expiry_date" required> --}}
                                            <input type="text" class="form-control" id="expiry_date"
                                            name="expiry_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea class="form-control" id="comment" name="comment"></textarea>
                                    </div>
                                    <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button></div>
                                </form>
                            </div>
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
