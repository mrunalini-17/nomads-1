

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
                        <h3 class="font-weight-bold text-primary">Create Incentive</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i> Back to view
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Incentive</h6>
                        </div>
                        <div class="card-body">

                                <form action="{{ route('intensive.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group mb-3 col col-6">
                                            <label for="user_id">User</label>
                                            <select name="user_id" id="user_id" class="form-control">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->first_name }}
                                                        {{ $user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 col col-6">
                                            <label for="enquire_id">Enquiry</label>
                                            <select name="enquire_id" id="enquire_id" class="form-control">
                                                @foreach ($enquiries as $enquiry)
                                                    <option value="{{ $enquiry->id }}">{{ $enquiry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 col col-6">
                                            <label for="booking_id">Booking</label>
                                            <select name="booking_id" id="booking_id" class="form-control">
                                                @foreach ($bookings as $booking)
                                                    <option value="{{ $booking->id }}">{{ $booking->customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 col col-6">
                                            <label for="amount">Amount</label>
                                            <input type="text" name="amount" id="amount" class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-right"><button type="submit" class="btn btn-primary">Create</button>
                                    </div>
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
