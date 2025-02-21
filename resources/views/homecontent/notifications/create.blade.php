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
                        <h3 class="font-weight-bold text-primary">Create Notification</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Notification</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('notifications.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="enquiry_id" class="form-label">Enquiry</label>
                                        <select name="enquiry_id" id="enquiry_id" class="form-control" required>
                                            @foreach ($enquiries as $enquiry)
                                                <option value="{{ $enquiry->id }}">{{ $enquiry->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="enquired_by" class="form-label">Enquired By</label>
                                        <select name="enquired_by" id="enquired_by" class="form-control" required>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
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
                                            <input type="checkbox" name="message_read" id="message_read" value="1" class="form-check-input">
                                            <label class="form-check-label" for="message_read">Yes</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="message_read_by_sales" class="form-label">Message Read By Sales</label>
                                        <select name="message_read_by_sales" id="message_read_by_sales" class="form-control">
                                            <option value="">None</option>
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

                                    <input type="hidden" name="added_by" value="{{ auth()->id() }}">
                                </div>

                                <div class="text-right">
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
