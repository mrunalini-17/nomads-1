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
                        <h3 class=" font-weight-bold text-primary">Edit Reminder</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa-solid fa-backward"></i> Back to view
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reminder Details</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reminders.update', $reminder->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- User Field -->
                                    <div class="form-group col-md-6">
                                        <label for="user_id" class="form-label">User</label>
                                        <select name="user_id" id="user_id" class="form-control" required>
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $reminder->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Booking Field -->
                                    <div class="form-group col-md-6">
                                        <label for="booking_id" class="form-label">Booking</label>
                                        <select name="booking_id" id="booking_id" class="form-control" required>
                                            <option value="">Select Booking</option>
                                            @foreach ($bookings as $booking)
                                                <option value="{{ $booking->id }}" {{ $reminder->booking_id == $booking->id ? 'selected' : '' }}>
                                                    {{ $booking->customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('booking_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Customer Field -->
                                    <div class="form-group col-md-6">
                                        <label for="customer_id" class="form-label">Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-control" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $reminder->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Message Field -->
                                    <div class="form-group col-md-6">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="4" required>{{ old('message', $reminder->message) }}</textarea>
                                        @error('message')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Reason Field -->
                                    <div class="form-group col-md-6">
                                        <label for="reason" class="form-label">Reason</label>
                                        <select name="reason" id="reason" class="form-control" required>
                                            <option value="booking" {{ $reminder->reason == 'booking' ? 'selected' : '' }}>Booking</option>
                                            <option value="alert" {{ $reminder->reason == 'alert' ? 'selected' : '' }}>Alert</option>
                                        </select>
                                        @error('reason')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Message Read Field -->
                                    <div class="form-group col-md-6">
                                        <label for="message_read" class="form-label">Message Read</label>
                                        <select name="message_read" id="message_read" class="form-control" required>
                                            <option value="1" {{ $reminder->message_read ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !$reminder->message_read ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('message_read')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Message Read By User Field -->
                                    <div class="form-group col-md-6">
                                        <label for="message_read_by_user" class="form-label">Message Read By User</label>
                                        <select name="message_read_by_user" id="message_read_by_user" class="form-control">
                                            <option value="">None</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $reminder->message_read_by_user == $user->id ? 'selected' : '' }}>
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('message_read_by_user')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group col-md-12 text-end mt-3">
                                        <button type="submit" class="btn btn-primary">Update Reminder</button>
                                    </div>
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
