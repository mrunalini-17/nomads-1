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
                    <div class=" py-3 px-2">
                        <h3 class=" font-weight-bold text-primary">Create Reminder</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i> Back to view
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reminder</h6>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('reminders.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="customer_id" class="form-label">Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-control" required>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="user_id" class="form-label">User</label>
                                        <select name="user_id" id="user_id" class="form-control" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="booking_id" class="form-label">Booking</label>
                                        <select name="booking_id" id="booking_id" class="form-control" required>
                                            @foreach ($bookings as $booking)
                                                <option value="{{ $booking->id }}">{{ $booking->customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="reason" class="form-label">Reason</label>
                                        <select name="reason" id="reason" class="form-control" required>
                                            <option value="booking">Booking</option>
                                            <option value="alert">Alert</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="message_read" class="form-label">Message Read</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="message_read" id="message_read" class="form-check-input" value="1">
                                            <label class="form-check-label" for="message_read">Yes</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="message_read_by_user" class="form-label">Message Read By User</label>
                                        <select name="message_read_by_user" id="message_read_by_user" class="form-control">
                                            <option value="">None</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                                    </div>

                                </div>

                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary">Create</button>
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
