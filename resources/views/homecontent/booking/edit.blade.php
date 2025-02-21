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
                <div class="container-fluid">

                    <h3 class="font-weight-bold text-primary">Edit Booking</h3>
                    <div class="text-right p-2">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p>ID : {{ $booking->unique_code }}</p>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                    </div>

                    <div class="card">

                        <div class="card-body bg-white">
                            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="section1-tab" data-toggle="tab" href="#section1"
                                            role="tab" aria-controls="section1" aria-selected="true">Booking
                                            Details</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="section2-tab" data-toggle="tab" href="#section2"
                                            role="tab" aria-controls="section2" aria-selected="false">Booking
                                            Details</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" id="section2-tab" data-toggle="tab" href="#section2"
                                            role="tab" aria-controls="section2" aria-selected="false">Service
                                            Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="section3-tab" data-toggle="tab" href="#section3"
                                            role="tab" aria-controls="section3" aria-selected="false">Transaction
                                            Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="section4-tab" data-toggle="tab" href="#section4"
                                            role="tab" aria-controls="section4" aria-selected="false">Remark Details</a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="tabContent">
                                    <!-- Section 1:  Booking Details -->
                                    <div class="tab-pane fade show active" id="section1" role="tabpanel"
                                        aria-labelledby="section1-tab">
                                        <div class="row">
                                            <!-- Booking Date -->
                                            <div class="col-md-4 mb-3">
                                                <label for="booking_date" class="form-label">Booking Date </label>
                                                <input type="text" id="booking_date"
                                                    class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}"
                                                    readonly>

                                            </div>

                                            <!-- Booking Status -->
                                            <div class="mb-3 col col-4">
                                                <label for="status" class="form-label">Booking Status <span class="text-danger">*</span></label>
                                                        @can('accounts')
                                                        <input type="text" name="status" id="status" class="form-control" value="{{$booking->status}}" readonly>
                                                    @else
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="Hold" {{ old('status', $booking->status) == 'Hold' ? 'selected' : '' }}>Hold</option>
                                                            <option value="Confirmed" {{ old('status', $booking->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="Rebooked" {{ old('status', $booking->status) == 'Rebooked' ? 'selected' : '' }}>Rebooked</option>
                                                            <option value="Cancelled" {{ old('status', $booking->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        </select>
                                                    @endcan
                                            </div>

                                            <!-- Service -->
                                            <div class="mb-3 col col-4">
                                                <label for="service_id" class="form-label">Service</label>
                                                        <input type="text" id="service_id" class="form-control"
                                                        value="{{ $booking->service->name }}"
                                                        readonly>
                                            </div>

                                        </div>
                                        <!-- Content for Customer Details -->
                                        <div class="row">
                                            <div class="mb-3 col col-4">

                                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                                <label for="customer_name" class="form-label">Customer</label>
                                                <input type="text" id="customer_name" class="form-control"
                                                    value="{{ $booking->customer ? $booking->customer->fname . ' ' . $booking->customer->lname : 'N/A' }}"
                                                    readonly>

                                                <input type="hidden" id="customer_id" name="customer_id"
                                                    value="{{ $booking->customer_id }}">
                                            </div>
                                            <!-- Customer Manager Dropdown -->
                                            <div class="mb-3 col col-4">
                                                <label for="customer_manager_id" class="form-label"> Customer Manager  </label>
                                                @if(is_null($booking->customer_manager_id))
                                                    <input type="text" id="customer_manager" class="form-control"  value="{{ 'N/A' }}" readonly>
                                                @else
                                                <input type="text" id="customer_manager" class="form-control"
                                                    value="{{ $booking->customerManager->fname . ' ' . $booking->customerManager->lname }}"
                                                    readonly>
                                                @endif
                                            </div>
                                            <!-- Adult and Child Count -->
                                            <div class="mb-3 col col-4">
                                                <label for="passenger_count_number" class="form-label">
                                                    Passengers Count
                                                </label>
                                                <input type="number" name="passenger_count" id="passenger_count_number"
                                                    class="form-control"
                                                    value="{{ old('passenger_count', $booking->passengerCounts->count()) }}"
                                                    required readonly>
                                            </div>

                                            @if ($booking->passengerCounts->count() > 0)
                                                <div class="col-12">
                                                    <h6 class="mt-3">Passenger Details</h6>
                                                    <table class="table mt-3" id="passengerTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                {{-- <th>Age</th> --}}
                                                                <th>Gender</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($booking->passengerCounts as $passenger)
                                                                <tr data-id="{{ $passenger->id }}">
                                                                    <td>{{ $passenger->name }}</td>
                                                                    {{-- <td>{{ $passenger->age }}</td> --}}
                                                                    <td>{{ ucfirst($passenger->gender) }}</td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-warning btn-sm editPassengerBtn"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm deletePassengerBtn"><i class="fa-solid fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="text-right mt-3">
                                            <button type="button" class="btn btn-secondary" onclick="previousTab(1)"
                                                hidden>Previous</button>
                                            <button type="button" class="btn btn-success" id="addPassengerBtn">Add
                                                    Passenger</button>
                                            <button type="button" class="btn btn-primary" onclick="nextTab(1)">Save &
                                                Next</button>
                                        </div>
                                    </div>

                                    <!-- Section 2: Service Details -->
                                    <div class="tab-pane fade" id="section2" role="tabpanel"
                                        aria-labelledby="section2-tab">

                                        <div class="row">
                                            <!-- Hidden field for booking ID -->
                                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                            <div class="col-12 text-right">
                                            </div>
                                            <table class="table mt-3" id="serviceTable">
                                                <thead>
                                                    <tr>
                                                        <th>Service Details</th>
                                                        <th>Travel Date 1</th>
                                                        <th>Travel Date 2</th>
                                                        <th>Confirmation Number</th>
                                                        <th>Gross Amount</th>
                                                        <th>Net Amount</th>
                                                        <th>Service Fees</th>
                                                        <th>Mask Fees</th>
                                                        <th>TCS</th>
                                                        <th>Bill To</th>
                                                        <th>Card Used</th>
                                                        <th>Supplier</th>
                                                        @cannot('accounts')
                                                        <th>Actions</th>
                                                        @endcannot
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($booking->serviceDetails as $service)
                                                        <tr data-id="{{ $service->id }}"
                                                            @if (!$service->is_approved)
                                                                style="background-color: #f8d7da;"
                                                            @endif>
                                                            <td>{{ $service->service_details }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($service->travel_date1)->format('d-m-Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($service->travel_date2)->format('d-m-Y') }}</td>
                                                            <td>{{ $service->confirmation_number }}</td>
                                                            <td>{{ $service->gross_amount }}</td>
                                                            <td>{{ $service->net }}</td>
                                                            <td>{{ $service->service_fees }}</td>
                                                            <td>{{ $service->mask_fees }}</td>
                                                            <td>{{ $service->tcs ?? '--' }}</td>
                                                            <td>
                                                                @if ($service->bill_to === 'self')
                                                                    Self
                                                                @else
                                                                    {{ $service->bill_to_remark }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $service->card->card_name ?? 'N/A' }}</td>
                                                            <td>{{ $service->supplier->name ?? 'N/A' }}</td>
                                                            @cannot('accounts')
                                                                <td>
                                                                    <button type="button" class="btn btn-warning btn-sm editServiceBtn">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger btn-sm deleteServiceBtn">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            @endcannot
                                                        </tr>
                                                    @endforeach
                                                </tbody>


                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="previousTab(2)">Previous</button>
                                                @cannot('accounts')
                                                <button type="button" class="btn btn-success" id="addServiceBtn">Add Service</button>
                                                @endcannot

                                            <button type="button" class="btn btn-primary" onclick="nextTab(2)">Save &
                                                Next</button>
                                        </div>
                                    </div>

                                    <!-- Section 3: Transaction Details -->
                                    <div class="tab-pane fade" id="section3" role="tabpanel"
                                        aria-labelledby="section3-tab">
                                        <!-- Content for Transaction Details -->
                                        <div class="row">
                                            <!-- Payment Type -->
                                            <div class="mb-3 col-3">
                                                <label for="payment_status" class="form-label">Payment Type </label>
                                                <input type="text" id="payment_status" class="form-control" value="{{ ucfirst($booking->payment_status) }}" readonly>
                                            </div>

                                            <!-- Payment Received Field -->
                                            <div id="payment-received-container" class="form-group mb-3 col-3 {{ $booking->payment_received_remark ? '' : 'd-none' }}">
                                                <label for="payment_received_remark">Payment Received </label>
                                                <input type="text" id="payment_received_remark" class="form-control" value="{{ old('payment_received_remark', $booking->payment_received_remark) }}" readonly>
                                            </div>

                                            <!-- Reminder Date and Time -->
                                            <div class="mb-3 col-3">
                                                <label for="office_reminder" class="form-label">Reminder Date and Time </label>
                                                <input type="datetime-local" name="office_reminder" id="office_reminder" class="form-control" value="{{ old('office_reminder', $booking->office_reminder) }}">
                                            </div>

                                            <!-- PAN Number -->
                                            <div class="mb-3 col-3">
                                                <label for="pan_number" class="form-label">PAN Number </label>
                                                <input type="text"  id="pan_number" class="form-control" value="{{ old('pan_number', $booking->pan_number) }}" readonly>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="previousTab(3)">Previous</button>
                                            <button type="button" class="btn btn-primary" onclick="nextTab(3)">Save &
                                                Next</button>
                                        </div>
                                    </div>

                                    <!-- Section 4: Remark Details -->
                                    <div class="tab-pane fade" id="section4" role="tabpanel"
                                        aria-labelledby="section4-tab">
                                        <!-- Content for Remark Details -->
                                        <div class="row">
                                            <!-- Table to display booking remarks -->
                                            <!-- Button to trigger Add Remark Modal -->
                                            <div class="col-12 text-right">

                                            </div>

                                            <table class="table mt-3" id="remarksTable">
                                                <thead>
                                                    <tr>
                                                        <th>Remark Type</th>
                                                        <th>Remark</th></th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Shared</th>
                                                        <th>Added by</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="remarksTableBody">
                                                    @forelse ($remarks as $remark)
                                                        @can('accounts')
                                                            @if ($remark->remark_type !== 'account')
                                                                @continue
                                                            @endif
                                                        @endcan

                                                        <tr data-id="{{ $remark->id }}">
                                                            <td>{{ $remark->remark_type }}</td>
                                                            <td>{{ $remark->description }}</td>
                                                            <td>{{ $remark->created_at->format('d/m/Y') }}</td> <!-- Format Date -->
                                                            <td>{{ $remark->created_at->format('H:i') }}</td>
                                                            <td>{{ $remark->is_shareable ? 'Yes' : 'No' }}</td>
                                                            <td>{{ $remark->addedBy->first_name ?? 'N/A' }} {{ $remark->addedBy->last_name ?? 'N/A' }}</td>


                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center">No remarks available for this booking</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>


                                            </table>


                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="previousTab(4)">Previous</button>
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#addRemarkModal">
                                                Add Remark
                                            </button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>




            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('shared.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    {{-- =============================================== --}}
    <!-- Add Remark Modal -->
    <div class="modal fade" id="addRemarkModal" tabindex="-1" role="dialog" aria-labelledby="addRemarkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addRemarkForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRemarkModalLabel">Add Remark</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="remark_type">Remark Type</label>
                            {{-- <input type="text" class="form-control" id="add_remark_type" name="remark_type" required> --}}
                            <select name="remark_type" id="remark_type" class="form-select form-control" required>
                                <option value="" disabled>Select</option>
                                @cannot('accounts')
                                <option value="client">Client</option>
                                @endcannot
                                <option value="office">Office</option>
                                <option value="account">Account</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_description">Description</label>
                            <textarea class="form-control" id="add_description" name="description" required></textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="add_is_active">Is Active</label>
                            <select class="form-control" id="add_is_active" name="is_active" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_is_acknowledged">Is Acknowledged</label>
                            <select class="form-control" id="add_is_acknowledged" name="is_acknowledged" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="add_is_shareable">Is Shareable</label>
                            <select class="form-control" id="add_is_shareable" name="is_shareable" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Remark Modal (will be populated dynamically) -->
    <div class="modal fade" id="editRemarkModal" tabindex="-1" role="dialog" aria-labelledby="editRemarkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editRemarkForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRemarkModalLabel">Edit Remark</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_remark_id" name="remark_id">
                        <div class="form-group">
                            <label for="edit_remark_type">Remark Type</label>
                            <input type="text" class="form-control" id="edit_remark_type" name="remark_type"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="edit_is_active">Is Active</label>
                            <select class="form-control" id="edit_is_active" name="is_active" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_is_acknowledged">Is Acknowledged</label>
                            <select class="form-control" id="edit_is_acknowledged" name="is_acknowledged" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="edit_is_shareable">Is Shareable</label>
                            <select class="form-control" id="edit_is_shareable" name="is_shareable" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ======================================================================= --}}
    <!-- Modal for Adding/Editing Passenger -->
    <div class="modal fade" id="passengerModal" tabindex="-1" role="dialog" aria-labelledby="passengerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="passengerForm">
                    @csrf
                    <!-- Include booking_id as a hidden input -->
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <input type="hidden" name="passenger_id" id="passenger_id">
                    <input type="hidden" id="_method" value="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="passengerModalLabel">Add/Edit Passenger</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="passenger_name">Name</label>
                            <input type="text" name="name" id="passenger_name" class="form-control" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="passenger_age">Age</label>
                            <input type="number" name="age" id="passenger_age" class="form-control" required>
                        </div> --}}
                        <div class="form-group">
                            <label for="passenger_gender">Gender</label>
                            <select name="gender" id="passenger_gender" class="form-control" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- JavaScript -->

        <script>
            // Handle Add Remark form submission
            $('#addRemarkForm').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                formData += `&booking_id={{ $booking->id }}`;

                $.ajax({
                    url: '{{ route('booking-remarks.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addRemarkModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
            // Handle Edit Remark button click
            $('.btn-edit-remark').on('click', function() {
                let remarkId = $(this).data('id');

                $.ajax({
                    url: `{{ url('booking-remarks') }}/${remarkId}/edit`,
                    method: 'GET',
                    success: function(response) {
                        // Populate edit form with response data
                        $('#edit_remark_id').val(response.id);
                        $('#edit_remark_type').val(response.remark_type);
                        $('#edit_description').val(response.description);
                        $('#edit_is_active').val(response.is_active ? 1 : 0);
                        $('#edit_is_acknowledged').val(response.is_acknowledged ? 1 : 0);
                        $('#edit_is_shareable').val(response.is_shareable ? 1 : 0);

                        $('#editRemarkModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Handle Edit Remark form submission
            $('#editRemarkForm').on('submit', function(e) {
                e.preventDefault();

                let remarkId = $('#edit_remark_id').val();
                let formData = $(this).serialize();

                $.ajax({
                    url: `{{ url('booking-remarks') }}/${remarkId}`,
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#editRemarkModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Handle Delete Remark button click
            $('.btn-delete').on('click', function() {
                let remarkId = $(this).data('id');

                if (confirm('Are you sure you want to delete this remark?')) {
                    $.ajax({
                        url: `{{ url('booking-remarks') }}/${remarkId}`,
                        method: 'DELETE',
                        success: function(response) {
                            $(`tr[data-id="${remarkId}"]`).remove();
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        </script>

    <!-- JavaScript for handling form submissions and AJAX requests -->
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Show modal for adding a new passenger
            $('#addPassengerBtn').click(function() {
                $('#passengerModalLabel').text('Add Passenger');
                $('#passengerForm')[0].reset();
                $('#passenger_id').val('');
                $('#_method').val('POST');
                $('#passengerModal').modal('show');
            });

            // Show modal for editing an existing passenger
            $('#passengerTable').on('click', '.editPassengerBtn', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');

                $.ajax({
                    url: '/passenger-counts/' + id + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#passengerModalLabel').text('Edit Passenger');
                        $('#passenger_id').val(data.id);
                        $('#passenger_name').val(data.name);
                        // $('#passenger_age').val(data.age);
                        $('#passenger_gender').val(data.gender);
                        $('#_method').val('PUT'); // Set method to PUT for updating
                        $('#passengerModal').modal('show');
                    }
                });
            });

            // Handle form submission for adding/editing a passenger
            $('#passengerForm').submit(function(e) {
                e.preventDefault();

                var id = $('#passenger_id').val();
                var method = $('#_method').val();
                var url = (id) ? '/passenger-counts/' + id : '/passenger-counts';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });

            // Handle passenger deletion
            $('#passengerTable').on('click', '.deletePassengerBtn', function() {
                if (!confirm('Are you sure you want to delete this passenger?')) {
                    return;
                }

                var row = $(this).closest('tr');
                var id = row.data('id');

                $.ajax({
                    url: '/passenger-counts/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // row.remove();
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>

    <!-- Add/Edit Service Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Add Service</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="serviceForm">
                        @csrf
                        <input type="hidden" name="service_id" id="service_id" value="">
                        <!-- Hidden field for booking ID -->
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <!-- Form Fields -->
                        <div class="form-group">
                            <label for="service_details">Service Details</label>
                            <input type="text" class="form-control" id="service_details" name="service_details"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="travel_date1">Travel Date 1</label>
                            <input type="date" class="form-control" id="travel_date1" name="travel_date1" required>
                        </div>
                        <div class="form-group">
                            <label for="travel_date2">Travel Date 2</label>
                            <input type="date" class="form-control" id="travel_date2" name="travel_date2">
                        </div>
                        <div class="form-group">
                            <label for="confirmation_number">Confirmation Number</label>
                            <input type="text" class="form-control" id="confirmation_number"
                                name="confirmation_number" required>
                        </div>
                        <div class="form-group">
                            <label for="gross_amount">Gross Amount</label>
                            <input type="number" class="form-control" id="gross_amount" name="gross_amount" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="net">Net Amount</label>
                            <input type="number" class="form-control" id="net" name="net" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="service_fees">Service Fees</label>
                            <input type="number" class="form-control" id="service_fees" name="service_fees"
                                step="0.01" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="mask_fees">Mask Fees</label>
                            <input type="number" class="form-control" id="mask_fees" name="mask_fees" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="tcs">TCS</label>
                            <input type="number" class="form-control" id="tcs" name="tcs" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="bill">Bill To</label>
                            <select name="bill_to" id="bill_to_1" class="form-select form-control" required>
                                <option value="">Select Billing Option</option>
                                <option value="self">Self</option>
                                <option value="company">Company</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bill">Bill To</label>
                            <input type="text" class="form-control" id="bill_to_remark" name="bill_to_remark" required>

                        </div>

                        <!-- Dropdown for Card ID -->
                        <div class="form-group">
                            <label for="card_id" class="form-label">Card Name</label>
                            <select class="form-control" id="card_id" name="card_id">
                                <option value="">Select a card</option>
                                @foreach ($cards as $card)
                                    <option value="{{ $card->id }}">{{ $card->card_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dropdown for Supplier ID -->
                        <div class="form-group">
                            <label for="supplier_id" class="form-label">Supplier Name</label>
                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                <option value="" disabled>Select a supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="saveServiceBtn">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let changes = [];
            // Track changes in form fields
            $('#serviceForm').on('input change', 'input, select, textarea', function () {
                const fieldName = $(this).attr('name'); // Get the field name
                if (fieldName && !changes.includes(fieldName)) {
                    changes.push(fieldName);
                }
                if (
                    ['gross_amount', 'net', 'mask_fees'].includes(fieldName) &&
                    !changes.includes('service_fees')
                ) {
                    changes.push('service_fees');
                }
            });

            $('#addServiceBtn').click(function() {
                $('#serviceModalLabel').text('Add Service');
                $('#serviceForm')[0].reset();
                $('#service_id').val('');
                $('#serviceModal').modal('show');
            });

            // Open the modal for editing an existing service
            $('#serviceTable').on('click', '.editServiceBtn', function() {
                var row = $(this).closest('tr');
                var serviceId = row.data('id');
                // Fetch the service details using AJAX
                $.ajax({
                    url: '{{ route('service-details.edit', ':id') }}'.replace(':id', serviceId),
                    method: 'GET',
                    success: function(data) {
                        $('#serviceModalLabel').text('Edit Service');
                        $('#service_id').val(data.id);
                        $('#service_details').val(data.service_details);
                        $('#travel_date1').val(data.travel_date1);
                        $('#travel_date2').val(data.travel_date2);
                        $('#confirmation_number').val(data.confirmation_number);
                        $('#gross_amount').val(data.gross_amount);
                        $('#net').val(data.net);
                        $('#service_fees').val(data.service_fees);
                        $('#mask_fees').val(data.mask_fees);
                        $('#bill').val(data.bill);
                        $('#tcs').val(data.tcs);
                        $('#bill_to_remark').val(data.bill_to_remark);
                        $('#supplier_id').val(data.supplier_id);
                        // Set the selected value for the card dropdown
                        $('#card_id').val(data.card_id);
                        $('#bill_to_1').val(data.bill_to);
                        $('#serviceModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Failed to fetch service details.');
                        console.log(xhr
                            .responseText); // Log errors to the console for debugging
                    }
                });
            });

            // Save the service details (add or edit)
            $('#serviceForm').submit(function(e) {
                e.preventDefault();
                var serviceId = $('#service_id').val();
                var url = serviceId ? '{{ route('service-details.update', ':id') }}'.replace(':id',
                    serviceId) : '{{ route('service-details.store') }}';
                var method = serviceId ? 'PUT' : 'POST';
                var formData = $(this).serializeArray();
                formData.push({ name: 'changes', value: JSON.stringify(changes) });

                console.log(changes);
                $.ajax({
                    url: url,
                    method: method,
                    data: $.param(formData),
                    success: function(response) {
                        if (response.success) {
                            $('#serviceModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = xhr.responseJSON.message || 'An error occurred.';
                        // Display errors
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, messages) {
                            $.each(messages, function(index, message) {
                                errorHtml += '<li>' + message + '</li>';
                            });
                        });
                        errorHtml += '</ul>';
                        // Show errors in a modal or alert
                        $('#errorAlert').html('Validation Errors: ' + errorHtml).removeClass('d-none');
                        console.log(xhr.responseText);
                    }
                });
            });
            // Delete a service
            $('#serviceTable').on('click', '.deleteServiceBtn', function() {
                var row = $(this).closest('tr');
                var serviceId = row.data('id');
                if (confirm('Are you sure you want to delete this service?')) {
                    $.ajax({
                        url: '{{ route('service-details.destroy', ':id') }}'.replace(':id',
                            serviceId),
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove();
                            } else {
                                alert('Failed to delete service.');
                            }
                        },
                        error: function(xhr) {
                            alert('Failed to delete service.');
                            console.log(xhr.responseText);
                        }
                    });
                }
            });


            // Function to calculate service fees
            function calculateServiceFees() {
                console.log("calclate service fees.....");

                    const grossAmountInput = document.querySelector('[id^="gross_amount"]');
                    const netAmountInput = document.querySelector('[id^="net"]');
                    const serviceFeesInput = document.querySelector('[id^="service_fees"]');
                    const maskFeesInput = document.querySelector('[id^="mask_fees"]');

                    const netAmountWarning = document.querySelector('[id^="net_amount_warning"]');
                    const maskFeesWarning = document.querySelector('[id^="mask_fees_warning"]');

                    if (!grossAmountInput || !netAmountInput || !serviceFeesInput || !maskFeesInput) {
                        return;
                    }

                    const grossAmount = parseFloat(grossAmountInput.value) || 0;
                    const netAmount = parseFloat(netAmountInput.value) || 0;
                    const maskFees = parseFloat(maskFeesInput.value) || 0;
                    //const billAmount = parseFloat(billAmountInput.value) || 0;

                    // Calculate service fees
                    const serviceFees = grossAmount - netAmount;
                    // Deduct mask fees from service fees
                    const finalServiceFees = grossAmount - netAmount - maskFees;
                    console.log(finalServiceFees);

                    // if (maskFees > serviceFees) {
                    //     maskFeesWarning.textContent = "Mask fees must be less than service fees.";
                    //     maskFeesInput.value = '';
                    //     return;
                    // }

                    serviceFeesInput.value = finalServiceFees.toFixed(2);
                    // netAmountWarning.textContent = ''; // Clear warning if valid
                    // maskFeesWarning.textContent = '';
                    //billAmountInput.value = finalServiceFees.toFixed(2);

            }

            let debounceTimer;

            // Event listener for net amount or mask fees input changes
            document.addEventListener('input', function(event) {
                if (event.target.matches('[id^="net"]') || event.target.matches('[id^="mask_fees"]') || event.target.matches('[id^="gross_amount"]') ) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function() {
                        calculateServiceFees();
                    }, 500);
                }
            });

        });
    </script>

    {{-- ============================= --}}

    <!-- Manager Modal -->
    <div class="modal fade" id="managerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manager Information</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('customer-managers.store') }}" method="POST">
                        {{-- <form method="POST"> --}}
                        @csrf
                        <div class="row">
                            <!-- Manager Information Form Fields -->
                            <div class="mb-3 col col-6">
                                <label for="fname" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fname" name="fname">
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="lname" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lname" name="lname">
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_mobile" class="form-label">Mobile <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_mobile" name="manager_mobile" oninput="document.getElementById('manager_whatsapp').value = this.value;">
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_whatsapp" class="form-label">WhatsApp <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_whatsapp"
                                    name="manager_whatsapp">
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="manager_email" name="manager_email">
                            </div>
                            <div class="mb-3 col-6">
                                <label for="manager_position" class="form-label">Position <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_position"
                                    name="manager_position">
                                <small class="form-text text-muted">e.g., PA, Manager, Admin, etc.</small>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveManagerInfo">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Booking Cancellation Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1" role="dialog" aria-labelledby="cancelBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="cancelBookingForm" method="POST" action="{{ route('bookings.cancel', $booking->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelBookingModalLabel">Cancel Booking Confirmation</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reason">Reason for Cancellation <span class="text-danger">*</span></label>
                            <textarea id="reason" name="reason" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="details">Details</label>
                            <textarea id="details" name="details" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="charges">Cancellation Charges <span class="text-danger">*</span></label>
                            <input type="number" id="charges" name="charges" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="charges_received">Charges Received <span class="text-danger">*</span></label>
                            <select id="charges_received" name="charges_received" class="form-control" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Search for customers
            $('#customer_search').on('input', function() {
                let query = $(this).val();
                if (query.length >= 2) { // Start searching after 2 characters
                    $.ajax({
                        url: '{{ route('customers.search') }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('#customer_results').empty();
                            if (response.customers.length > 0) {
                                response.customers.forEach(function(customer) {
                                    $('#customer_results').append(`
                                <li class="list-group-item" data-id="${customer.id}" data-name="${customer.fname} ${customer.lname}">
                                    ${customer.fname} ${customer.lname}
                                </li>
                            `);
                                });
                                $('#customer_results').show();
                            } else {
                                $('#customer_results').append(`
                            <li class="list-group-item disabled text-danger d-flex justify-content-between align-items-center">
                                <span>Name does not exist</span>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </li>
                        `);
                                $('#customer_results').show();
                            }
                        }
                    });
                } else {
                    $('#customer_results').hide();
                    $('#customer_manager_search').val('');
                    $('#customer_manager_id').val('');
                    $('#manager_results').hide();
                }
            });

            // Search for managers
            $('#customer_manager_search').on('input', function() {
                let query = $(this).val();
                let customerId = $('#customer_id').val();
                if (query.length >= 2 && customerId) { // Start searching after 2 characters
                    $.ajax({
                        url: '{{ route('managers.search') }}',
                        method: 'GET',
                        data: {
                            query: query,
                            customer_id: customerId
                        },
                        success: function(response) {
                            $('#manager_results').empty();
                            if (response.managers.length > 0) {
                                response.managers.forEach(function(manager) {
                                    $('#manager_results').append(`
                                <li class="list-group-item" data-id="${manager.id}" data-name="${manager.fname} ${manager.lname}">
                                    ${manager.fname} ${manager.lname}
                                </li>
                            `);
                                });
                                $('#manager_results').show();
                            } else {
                                $('#manager_results').append(`
                            <li class="list-group-item disabled text-danger">No managers found</li>
                        `);
                                $('#manager_results').show();
                            }
                        }
                    });
                } else {
                    $('#manager_results').hide();
                }
            });

            // Select customer from dropdown
            $('#customer_results').on('click', 'li:not(.disabled)', function() {
                let customerId = $(this).data('id');
                let customerName = $(this).data('name');
                $('#customer_search').val(customerName);
                $('#customer_id').val(customerId);
                $('#customer_results').hide();
                loadCustomerManager(customerId);
            });

            // Select manager from dropdown
            $('#manager_results').on('click', 'li:not(.disabled)', function() {
                let managerId = $(this).data('id');
                let managerName = $(this).data('name');
                $('#customer_manager_search').val(managerName);
                $('#customer_manager_id').val(managerId);
                $('#manager_results').hide();
            });

            // Load manager for the selected customer
            function loadCustomerManager(customerId) {
                $.ajax({
                    url: '{{ route('managers.search') }}',
                    method: 'GET',
                    data: {
                        customer_id: customerId
                    },
                    success: function(response) {
                        if (response.managers.length > 0) {
                            let manager = response.managers[0];
                            $('#customer_manager_search').val(`${manager.fname} ${manager.lname}`);
                            $('#customer_manager_id').val(manager.id);
                            $('#manager_results').hide();
                        } else {
                            $('#customer_manager_search').val('');
                            $('#customer_manager_id').val('');
                            $('#manager_results').hide();
                        }
                    }
                });
            }
        });
    </script>
    {{-- =============================== --}}
    <script>
        function toggleFields() {
            const paymentStatus = document.getElementById('payment_status').value;
            const paymentReceivedContainer = document.getElementById('payment-received-container');

            if (paymentStatus === 'instant') {
                paymentReceivedContainer.classList.remove('d-none'); // Show the input field
            } else {
                paymentReceivedContainer.classList.add('d-none'); // Hide the input field
            }
        }
    </script>

       <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            // Format dates as yyyy-mm-dd
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            const todayStr = formatDate(today);
            const yesterdayStr = formatDate(yesterday);

            const bookingDateInput = document.getElementById('booking_date');
            bookingDateInput.setAttribute('min', yesterdayStr); // Disable dates before yesterday
            bookingDateInput.removeAttribute('max'); // Allow future dates
        });
    </script>
   {{-- travel date --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const travelDate1 = document.getElementById('travel_date1');
        const travelDate2 = document.getElementById('travel_date2');

        // Disable past dates for Travel Date 1
        const today = new Date().toISOString().split('T')[0];
        //travelDate1.setAttribute('min', today);

        // Event listener for Travel Date 1
        travelDate1.addEventListener('change', function () {
            const selectedDate1 = new Date(travelDate1.value);

            // Set Travel Date 2 min date to the same date as Travel Date 1
            const minDate2 = selectedDate1.toISOString().split('T')[0];
            travelDate2.setAttribute('min', minDate2);

            // Reset Travel Date 2 value if it is out of the valid range
            if (travelDate2.value && travelDate2.value < minDate2) {
                travelDate2.value = '';
            }
        });
    });
</script>
    {{-- ===================== --}}
<script>
    function nextTab(current) {
        const next = current + 1;
        if (document.querySelector(`#section${next}`)) {
            document.querySelector(`#section${current}`).classList.remove('show', 'active');
            document.querySelector(`#section${next}`).classList.add('show', 'active');
            document.querySelector(`#section${current}-tab`).classList.remove('active');
            document.querySelector(`#section${next}-tab`).classList.add('active');
        }
    }

    function previousTab(current) {
        const previous = current - 1;
        if (document.querySelector(`#section${previous}`)) {
            document.querySelector(`#section${current}`).classList.remove('show', 'active');
            document.querySelector(`#section${previous}`).classList.add('show', 'active');
            document.querySelector(`#section${current}-tab`).classList.remove('active');
            document.querySelector(`#section${previous}-tab`).classList.add('active');
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var statusSelect = document.getElementById('status');
        var previousValue = statusSelect.value;

        statusSelect.addEventListener('change', function() {
            var selectedValue = this.value;

            if (selectedValue === 'Cancelled') {

                $('#cancelBookingModal').modal('show');

                // If the user cancels the modal, revert the status dropdown
                $('#cancelBookingModal').on('hidden.bs.modal', function() {
                    if (!$('#cancelBookingForm').data('submitted')) {
                        statusSelect.value = previousValue;
                    }
                });
            } else {
                // Update the previous value to the newly selected value
                previousValue = selectedValue;
            }
        });

        // Handle form submission
        $('#cancelBookingForm').on('submit', function(e) {
            $(this).data('submitted', true);
        });
    });
</script>


@endsection
