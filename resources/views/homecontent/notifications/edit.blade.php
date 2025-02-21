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
                        <h3 class="font-weight-bold text-primary">Edit Notification</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i> Back to view
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Notification</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('notifications.update', $notification->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="enquiry_id" class="form-label">Enquiry</label>
                                        <select name="enquiry_id" id="enquiry_id" class="form-control">
                                            @foreach ($enquiries as $enquiry)
                                                <option value="{{ $enquiry->id }}" {{ $notification->enquiry_id == $enquiry->id ? 'selected' : '' }}>
                                                    {{ $enquiry->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="enquired_by" class="form-label">Enquired By</label>
                                        <select name="enquired_by" id="enquired_by" class="form-control">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $notification->enquired_by == $user->id ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="booking_id" class="form-label">Booking</label>
                                        <select name="booking_id" id="booking_id" class="form-control">
                                            @foreach ($bookings as $booking)
                                                <option value="{{ $booking->id }}" {{ $notification->booking_id == $booking->id ? 'selected' : '' }}>
                                                    {{ $booking->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="reason" class="form-label">Reason</label>
                                        <select name="reason" id="reason" class="form-control">
                                            <option value="booking" {{ $notification->reason == 'booking' ? 'selected' : '' }}>Booking</option>
                                            <option value="alert" {{ $notification->reason == 'alert' ? 'selected' : '' }}>Alert</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="4">{{ $notification->message }}</textarea>
                                    </div>
                                </div>

                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
