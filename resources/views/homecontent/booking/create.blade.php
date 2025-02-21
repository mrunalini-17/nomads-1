@extends('layout.app')
@section('title', 'Create Booking')

<style>
    .iti{
        display : block;
    }
</style>

@section('content')
    <style>
        #submitButton[disabled] {
            cursor: not-allowed;
            background-color: #ccc;
            border-color: #ccc;
        }
    </style>
    <div id="wrapper">
        @include('shared.adminsidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('shared.navbar')

                <div class="container-fluid">
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                            Back
                        </a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Booking</h6>
                        </div>
                        <div class="card-body">
                            <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="section1-tab" data-bs-toggle="tab" href="#section1"
                                            role="tab" aria-controls="section1" aria-selected="true">Booking
                                            Details</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="section2-tab" data-bs-toggle="tab" href="#section2"
                                            role="tab" aria-controls="section2" aria-selected="false">Service
                                            Details</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="section3-tab" data-bs-toggle="tab" href="#section3"
                                            role="tab" aria-controls="section3" aria-selected="false">Transaction
                                            Details</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="section4-tab" data-bs-toggle="tab" href="#section4"
                                            role="tab" aria-controls="section4" aria-selected="false">Remark Details</a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="tabContent">
                                    <!-- Section 1 Booking -->
                                    <div class="tab-pane fade show active" id="section1" role="tabpanel"
                                        aria-labelledby="section1-tab">
                                        <div class="row">
                                            <input type="hidden" name="have_has_manager" id="have_has_manager" value="0">
                                             <!-- Booking Date -->
                                            <div class="mb-3 col col-4">
                                                <label for="booking_date" class="form-label">Booking Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="booking_date" id="booking_date"
                                                    class="form-control">
                                                <small class="errors text-danger" id="booking_date_error"></small>
                                            </div>
                                            <!-- Booking Status -->
                                            <div class="mb-3 col col-4">
                                                <label for="status" class="form-label">Booking Status <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value=""disabled selected>Select status</option>
                                                    <option value="Hold">Hold</option>
                                                    <option value="Confirmed">Confirmed</option>
                                                    {{-- <option value="Rebooked">Rebooked</option>
                                                    <option value="Cancelled">Cancelled</option> --}}
                                                </select>
                                                <small class="errors text-danger" id="status_error"></small>
                                            </div>

                                            <!-- Service -->
                                            <div class="mb-3 col col-4">
                                                <label for="service_id" class="form-label">Service <span
                                                        class="text-danger">*</span></label>
                                                <select name="service_id" id="service_id" class="form-control">
                                                    <option value="">Select service</option>
                                                    @foreach ($services as $service)
                                                        <!-- Add a specific value or identifier for international tours -->
                                                        <option value="{{ $service->id }}"
                                                            data-name="{{ $service->name }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                                <small class="errors text-danger" id="service_error"></small>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <!-- Customer Search Input -->
                                            <div class="mb-3 col col-4">
                                                <label for="customer_search" class="form-label">Customer <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="d-flex align-items-center position-relative">
                                                    <input type="text" id="customer_search" name="customer_search"
                                                        class="form-control me-2" placeholder="Search for a customer">
                                                    <button type="button" class="btn btn-primary" id="add-customer-btn" data-bs-toggle="modal"
                                                        data-bs-target="#customerModal">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <ul id="customer_results" class="list-group position-absolute w-100"
                                                        style="top: 100%; z-index: 1000; display: none;">
                                                        <!-- Search results will be appended here -->
                                                    </ul>
                                                    <input type="hidden" id="customer_id" name="customer_id">
                                                </div>
                                                <small>*Select the customer from options only. If not found, please add the customer first.</small>
                                                <small class="errors text-danger" id="customer_error"></small>
                                            </div>

                                            <!-- Customer Manager Input -->
                                            <div class="mb-3 col col-4">
                                                <label for="customer_manager_search" class="form-label">Customer
                                                    Manager </label>
                                                <div class="d-flex align-items-center position-relative">
                                                    <input type="text" id="customer_manager_search"
                                                        name="customer_manager_search" class="form-control me-2"
                                                        placeholder="Search for a manager">
                                                    <button type="button" id="add-manager-btn" class="btn btn-primary"
                                                        data-bs-toggle="modal" data-bs-target="#managerModal">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <ul id="manager_results" class="list-group position-absolute w-100"
                                                        style="top: 100%; z-index: 1000; display: none;">
                                                        <!-- Search results will be appended here -->
                                                    </ul>
                                                    <input type="hidden" id="customer_manager_id"
                                                        name="customer_manager_id">
                                                </div>
                                                <small>*Select the customer first for adding a manager.</small>
                                                <small class="errors text-danger" id="customer_manager_error"></small>
                                                <div id="manager_info" class="mt-2"></div>
                                            </div>

                                            <!-- Passenger Count -->
                                            <div class="mb-3 col col-4">
                                                <label for="passenger_count_number" class="form-label">Passengers
                                                    Count </label>
                                                <input type="number" name="passenger_count" id="passenger_count_number"
                                                    class="form-control">
                                            </div>

                                            <!-- Dynamic Passengers Table -->
                                            <div id="passengers-container" class="mb-3 d-none col col-12">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Gender</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="passengers-table-body">
                                                        <!-- Dynamic rows will be inserted here -->
                                                    </tbody>
                                                </table>
                                            </div>




                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="nextTab(1)">Save &
                                                Next</button>
                                        </div>
                                    </div>

                                    <!-- Section 2 Services-->
                                    <div class="tab-pane fade" id="section2" role="tabpanel"
                                        aria-labelledby="section2-tab">
                                        <div id="service-details-container">

                                            <!-- Initial Service Details Group -->
                                            <div class="row service-details-group mb-3">
                                                <div class="service-heading mb-3 col col-12">
                                                    <h4 class="text-info"><b>Service 1</b></h4>
                                                </div>
                                                <!-- Service Details -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="service_details_1">Service Details <span
                                                                class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" id="service_details_1" name="service_details[]"
                                                            placeholder="Enter service details"></textarea>
                                                    </div>
                                                </div>
                                                <!-- Travel Date 1 -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="travel_date1_1">Travel Date 1 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="travel_date1_1"
                                                            name="travel_date1[]">
                                                    </div>
                                                </div>
                                                <!-- Travel Date 2 -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="travel_date2_1">Travel Date 2</label>
                                                        <input type="date" class="form-control" id="travel_date2_1"
                                                            name="travel_date2[]">
                                                    </div>
                                                </div>

                                                <!-- Confirmation Number -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="confirmation_number_1">Confirmation Number <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            id="confirmation_number_1" name="confirmation_number[]"
                                                            placeholder="Enter confirmation number">
                                                    </div>
                                                </div>
                                                <!-- Gross Amount -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="gross_amount">Gross Amount <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="gross_amount_1"
                                                            name="gross_amount[]" step="0.01">
                                                    </div>
                                                </div>

                                                <!-- Net Amount -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="net_1">Net Amount <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="net_1"
                                                            name="net[]" placeholder="Enter net amount" step="0.01">
                                                        <small id="net_amount_warning"
                                                            class="form-text text-danger"></small>
                                                    </div>
                                                </div>

                                                <!-- Service Fees -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="service_fees_1">Service Fees <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="service_fees_1"
                                                            name="service_fees[]" placeholder="Enter service fees" step="0.01" readonly>
                                                    </div>
                                                </div>

                                                <!-- Mask Fees -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="mask_fees_1">Mask Fees </label>
                                                        <input type="number" class="form-control" id="mask_fees_1"
                                                            name="mask_fees[]" value="0.00"
                                                            placeholder="Enter mask fees" step="0.01"s>
                                                        <small id="mask_fees_warning"
                                                            class="form-text text-danger"></small>
                                                    </div>
                                                </div>

                                                 <!-- TCS -->
                                                 <div class="mb-3 col-3 d-none" id="tcs_container">
                                                    <div class="form-group">
                                                        <label for="tcs_1">TCS </label>
                                                        <input type="number" class="form-control" id="tcs_1"
                                                            name="tcs[]" step="0.01" placeholder="Enter TCS amount">
                                                    </div>
                                                </div>

                                                    <!-- Bill To Dropdown -->
                                                <div class="mb-3 col col-3">
                                                    <div class="form-group">
                                                        <label for="bill_to_1" class="form-label">Bill To <span class="text-danger">*</span></label>
                                                        <select name="bill_to[]" id="bill_to_1" class="form-select form-control">
                                                            <option value="" disabled selected>Select Billing Option</option>
                                                            <option value="self">Self</option>
                                                            <option value="company">Company</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Bill To Remark Field (for all options) -->
                                                <div id="bill_to_remark_div_1" class="form-group mb-3 col col-3 d-none">
                                                    <label for="bill_to_remark_1" class="form-label">Bill To Remark(Self) <span class="text-danger">*</span></label>
                                                    <input type="text" id="bill_to_remark_1" name="bill_to_remark[]" class="form-control" readonly>
                                                </div>

                                                <!-- Company Search Input -->
                                                <div id="company_search_div_1" class="form-group mb-3 col col-3 d-none">
                                                    <label for="company_search_1" class="form-label">Search Company <span class="text-danger">*</span></label>
                                                    <div class="d-flex align-items-center position-relative">
                                                        <input type="text" id="company_search_1" class="form-control me-2" placeholder="Search for a company">
                                                        <button type="button" id="add_company1" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#companyModal" data-index="1">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <ul id="company_results_1" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                                                            <!-- Search results will be appended here -->
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- Other Search Input -->
                                                <div id="other_search_div_1" class="form-group mb-3 col col-3 d-none">
                                                    <label for="other_search_1" class="form-label">Search Other <span class="text-danger">*</span></label>
                                                    <div class="d-flex align-items-center position-relative">
                                                        <input type="text" id="other_search_1" class="form-control me-2" placeholder="Search for other customer">
                                                        <button type="button" id="add_other1" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#otherModal" data-index="1">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <ul id="other_results_1" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                                                            <!-- Search results will be appended here -->
                                                        </ul>
                                                    </div>
                                                </div>


                                                <!-- Bill Amount -->
                                                {{-- <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="bill_1">Bill Amount: <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" id="bill_1"
                                                            name="bill[]" step="0.01"
                                                            placeholder="Enter bill amount">
                                                        <small id="bill_amount_warning"
                                                            class="form-text text-danger"></small>
                                                    </div>
                                                </div> --}}



                                                <!-- Credit Card Used -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="card_id_1">Credit Card Used </label>
                                                        <select id="card_id_1" name="card_id[]"
                                                            class="form-select form-control">
                                                            <option value="">Select Card</option>
                                                            @foreach ($cards as $card)
                                                                <option value="{{ $card->id }}">{{ $card->card_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Supplier -->
                                                <div class="mb-3 col-3">
                                                    <div class="form-group">
                                                        <label for="supplier_id_1">Supplier <span
                                                                class="text-danger">*</span></label>
                                                        <div class="d-flex align-items-center position-relative">
                                                            <input type="text" id="supplier_search_1" class="form-control me-2" placeholder="Search for supplier">
                                                            <button type="button" id="add_supplier1" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#supplierModal" data-index="1">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                            <ul id="supplier_results_1" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                                                                <!-- Search results will be appended here -->
                                                            </ul>
                                                            <input type="hidden" id="supplier_id_1" name="supplier_id[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4 text-right">
                                            <button type="button" id="cancel-service-button"
                                                class="btn btn-danger d-none">Cancel
                                            </button>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="previousTab(0)">Previous</button>

                                            <button type="button" class="btn btn-success" id="add-service-button">Add
                                                More Service</button>

                                            <button type="button" class="btn btn-primary" onclick="nextTab(2)">Save &
                                                Next</button>
                                        </div>
                                    </div>


                                    <!-- Section 3 Transaction Details-->
                                    <div class="tab-pane fade" id="section3" role="tabpanel"
                                        aria-labelledby="section3-tab">
                                        <div class="row">
                                            <!-- Payment Type -->
                                            <div class="mb-3 col col-4">
                                                <div class="form-group">
                                                    <label for="payment_status" class="form-label">Payment Type <span
                                                            class="text-danger">*</span></label>
                                                    <select name="payment_status" id="payment_status"
                                                        class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="instant">Instant</option>
                                                        <option value="advance">Advance</option>
                                                        <option value="credit">Credit</option>
                                                    </select>
                                                </div>
                                            </div>

                                             <!-- Payment Received Field -->
                                             <div class="form-group mb-3 col col-4">
                                                <label for="payment_received_remark">Remarks for payment recieved <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="payment_received_remark"
                                                    id="payment_received_remark" class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <!-- PAN Number -->
                                            <div class="mb-3 col col-4">
                                                <div class="form-group">
                                                    <label for="pan_number" class="form-label">PAN Number </label>
                                                    <input type="text" name="pan_number" id="pan_number" class="form-control" placeholder="Enter PAN Number" maxlength="10" pattern="[A-Z0-9]{10}" title="PAN must be 10 alphanumeric characters, no spaces or special characters">
                                                </div>
                                            </div>


                                            <!-- Reminder Date and Time -->
                                            <div class="form-group mb-3 col col-4">
                                                <label for="office_reminder" class="form-label">Reminder Date and Time </label>
                                                <input type="datetime-local" name="office_reminder" id="office_reminder" class="form-control">
                                            </div>

                                            {{-- <div class="mb-3 col col-4">
                                                <label for="invoice_number" class="form-label">Invoice Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="invoice_number" id="invoice_number"
                                                    class="form-control" placeholder="">
                                            </div> --}}
                                        </div>


                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="previousTab(1)">Previous</button>
                                            <button type="button" class="btn btn-primary" onclick="nextTab(3)">Save &
                                                Next</button>
                                        </div>
                                    </div>

                                    <!-- Section 4 -->
                                    <div class="tab-pane fade" id="section4" role="tabpanel"
                                        aria-labelledby="section4-tab">
                                        <div class="row">
                                            <div class="form-group mb-3 col col-4">
                                                <label for="client_remark">Client Remark </label>
                                                <textarea name="client_remark" id="client_remark" class="form-control" rows="2"
                                                    placeholder="Enter client remark"></textarea>
                                                <div class="p-3">
                                                    <input type="hidden" name="client_remark_shareable" value="1">
                                                    <input type="checkbox" name="client_remark_shareable" id="client_remark_shareable" class="form-check-input" value="0">
                                                    <label for="client_remark_shareable" class="form-check-label">Don't share client remark</label>
                                                </div>

                                            </div>

                                            <!-- Account Remark -->
                                            <div class="form-group mb-3 col col-4">
                                                <label for="account_remark">Account Remark </label>
                                                <textarea name="account_remark" id="account_remark" class="form-control" rows="2"
                                                    placeholder="Enter account remark"></textarea>
                                            </div>

                                            <!-- Office Remark -->
                                            <div class="form-group mb-3 col col-4">
                                                <label for="office_remark">Office Remark </label>
                                                <textarea name="office_remark" id="office_remark" class="form-control" rows="2"
                                                    placeholder="Enter office remark"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-3 col">
                                            <div  class="p-3">
                                                <input type="hidden" name="mm_shareable" value="1">
                                                <input type="checkbox" name="mm_shareable" id="mm_shareable" class="form-check-input" value="0">
                                                <label for="mm_shareable" class="form-check-label">Don't send mail and message</label>
                                            </div>
                                            <div class="p-3">
                                                <input type="hidden" name="amount_shareable" value="1">
                                                <input type="checkbox" name="amount_shareable" id="amount_shareable" class="form-check-input" value="0">
                                                <label for="amount_shareable" class="form-check-label">Don't share bill amount</label>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="previousTab(2)">Previous</button>
                                            <button type="submit" class="btn btn-success" id="submitButton"
                                                disabled>Submit</button>
                                        </div>
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

    <!-- Customer Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Add Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="customerForm">
                        @csrf

                        <div class="mb-3">
                            <input type="checkbox" id="have_manager" name="have_manager" value="0">
                            <label for="have_manager" class="form-label">Has Manager</label>
                        </div>


                        <div class="row">
                            <div class="mb-3 col col-6">
                                <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fname" name="fname">
                                <small id="fnameError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lname" name="lname">
                                <small id="lnameError" class="form-text text-danger"></small>
                            </div>

                            <div class="mb-3 col col-6">
                                <label for="gender" class="form-label">Gender <span class="text-danger"><sup>*</sup></span></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3 col col-6" id="emailField">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" class="form-control" id="email" name="email">
                                <small class="text-danger" id="error-email"></small>
                            </div>

                            <div class="mb-3 col col-6" id="mobileField">
                                <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="mobile" name="mobile">
                                <small id="mobileError" class="form-text text-danger"></small>
                                <small class="text-danger" id="error-mobile"></small>
                            </div>
                            <div class="mb-3 col col-6" id="whatsappField">
                                <label for="whatsapp" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="whatsapp" name="whatsapp">
                                <small id="whatsappError" class="form-text text-danger"></small>
                                <small class="text-danger" id="error-whatsapp"></small>
                            </div>


                            <div class="mb-3 col col-6">
                                <label for="locality" class="form-label">Locality </label>
                                <textarea class="form-control" id="locality" name="locality" rows="1"></textarea>
                            </div>

                            <div class="mb-3 col col-6">
                                <label for="pincode" class="form-label">Pincode </label>
                                <input type="number" class="form-control" id="pincode" name="pincode">
                            </div>


                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="country_id">Country </label>
                                    <select class="form-control @error('country_id') is-invalid @enderror" id="country_id"
                                        name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}> {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="state_id">State</label>
                                    <select class="form-control @error('state_id') is-invalid @enderror" id="state_id"
                                        name="state_id">
                                        <option value="">Select State</option>
                                    </select>
                                    @error('state_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="city_id">City </label>
                                    <select class="form-control @error('city_id') is-invalid @enderror" id="city_id"
                                        name="city_id">
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="reference_id">Reference </label>
                                    <select class="form-control @error('reference_id') is-invalid @enderror"
                                        id="reference_id" name="reference_id">
                                        <option value="">Select reference</option>
                                        @foreach ($references as $reference)
                                            <option value="{{ $reference->id }}"
                                                {{ old('reference_id') == $reference->id ? 'selected' : '' }}>
                                                {{ $reference->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('reference_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <input type="hidden" name="have_company" value="0">
                        </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Manager Modal -->
    <div class="modal fade" id="managerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manager Information</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="customerManagerForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="customer_id" id="manager_customer_id">
                            <p id="manager_customer_idError" class="form-text text-danger"></p>
                            <!-- Manager Information Form Fields -->
                            <div class="mb-3 col col-6">
                                <label for="manager_fname" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_fname" name="manager_fname" required>
                                <small id="manager_fnameError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_lname" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_lname" name="manager_lname" required>
                                <small id="manager_lnameError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_gender" class="form-label">Gender <span class="text-danger"><sup>*</sup></span></label>
                                <select class="form-control" id="manager_gender" name="manager_gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <small id="manager_genderError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_email" class="form-label">Email </label>
                                <input type="email" class="form-control" id="manager_email" name="manager_email">
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_mobile" class="form-label">Mobile <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_mobile" name="manager_mobile" required oninput="document.getElementById('manager_whatsapp').value = this.value;">
                                <small id="manager_mobileError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="manager_whatsapp" class="form-label">WhatsApp <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="manager_whatsapp"
                                    name="manager_whatsapp" required>
                                    <small id="manager_whatsappError" class="form-text text-danger"></small>
                            </div>

                            {{-- <div class="mb-3 col-6">
                                <label for="manager_position" class="form-label">Position </label>
                                <input type="text" class="form-control" id="manager_position"
                                    name="manager_position">
                                <small class="form-text text-muted">e.g., PA, Manager, Admin, etc.</small>
                            </div> --}}
                            <div class="mb-3 col col-6">
                                <label for="locality" class="form-label">Locality </label>
                                <textarea class="form-control" id="manager_locality" name="manager_locality" rows="1"></textarea>
                            </div>

                            <div class="mb-3 col col-6">
                                <label for="pincode" class="form-label">Pincode </label>
                                <input type="number" class="form-control" id="manager_pincode" name="manager_pincode">
                            </div>


                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="manager_country_id">Country </label>
                                    <select class="form-control @error('manager_country_id') is-invalid @enderror" id="manager_country_id"
                                        name="manager_country_id">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('manager_country_id') == $country->id ? 'selected' : '' }}> {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('manager_country_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="manager_state_id">State</label>
                                    <select class="form-control @error('state_id') is-invalid @enderror" id="manager_state_id"
                                        name="manager_state_id">
                                        <option value="">Select State</option>
                                    </select>
                                    @error('manager_state_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="manager_city_id">City </label>
                                    <select class="form-control @error('manager_city_id') is-invalid @enderror" id="manager_city_id"
                                        name="manager_city_id">
                                        <option value="">Select City</option>
                                    </select>
                                    @error('manager_city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            {{-- <input type="hidden" name="have_company" value="0">
                            <input type="hidden" name="have_manager" value="0"> --}}

                        </div>

                </div>
                <div class="modal-footer  d-flex justify-content-center">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-primary" id="saveManagerInfo">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Company Modal -->
    <div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Add Company</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <!-- Company Fields -->
                    <input type="hidden" name="customer_id" id="company_customer_id">
                    <p id="company_customer_idError" class="form-text text-danger"></p>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" id="company_name" class="form-control">
                        <small id="company_nameError" class="form-text text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="company_mobile" class="form-label">Mobile </label>
                        <input type="text" name="company_mobile" id="company_mobile" class="form-control">
                        <small id="company_mobileError" class="form-text text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="company_gst" class="form-label">GST Number </label>
                        <input type="text" name="company_gst" id="company_gst" class="form-control">
                        <small id="company_gstError" class="form-text text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label for="company_address" class="form-label">Address </label>
                        <textarea name="company_address" id="company_address" class="form-control"></textarea>
                        <small id="company_addressError" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveCompanyButton" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Modal -->
    <div class="modal fade" id="otherModal" tabindex="-1" aria-labelledby="otherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otherModalLabel">Add Other Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="otherCustomerForm">

                        @csrf
                        <div class="row">
                            <div class="mb-3 col col-6">
                                <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ofname" name="fname">
                                <small id="ofnameError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="olname" name="lname">
                                <small id="olnameError" class="form-text text-danger"></small>
                            </div>

                            <div class="mb-3 col col-6">
                                <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="omobile" name="mobile" oninput="document.getElementById('owhatsapp').value = this.value;">
                                <small id="omobileError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="whatsapp" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="owhatsapp" name="whatsapp">
                                <small id="owhatsappError" class="form-text text-danger"></small>
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" class="form-control" id="oemail" name="email">
                            </div>
                            <div class="mb-3 col col-6">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3 col col-6">
                                <label for="locality" class="form-label">Locality </label>
                                <textarea class="form-control" id="olocality" name="locality" rows="1"></textarea>
                            </div>

                            <div class="mb-3 col col-6">
                                <label for="pincode" class="form-label">Pincode </label>
                                <input type="number" class="form-control" id="opincode" name="pincode">
                            </div>


                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="country_id">Country </label>
                                    <select class="form-control @error('country_id') is-invalid @enderror" id="country_id"
                                        name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="state_id">State</label>
                                    <select class="form-control @error('state_id') is-invalid @enderror" id="state_id"
                                        name="state_id">
                                        <option value="">Select State</option>
                                        {{-- @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}</option>
                                            @endforeach --}}
                                    </select>
                                    @error('state_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="city_id">City </label>
                                    <select class="form-control @error('city_id') is-invalid @enderror" id="city_id"
                                        name="city_id">
                                        <option value="">Select City</option>
                                        {{-- @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach --}}
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 col col-6">
                                <div class="form-group">
                                    <label for="reference_id">Reference </label>
                                    <select class="form-control @error('reference_id') is-invalid @enderror"
                                        id="reference_id" name="reference_id">
                                        <option value="">Select reference</option>
                                        @foreach ($references as $reference)
                                            <option value="{{ $reference->id }}"
                                                {{ old('reference_id') == $reference->id ? 'selected' : '' }}>
                                                {{ $reference->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('reference_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="have_manager" value="0">
                            <input type="hidden" name="have_company" value="0">



                        </div>


                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="customerFormSubmit">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="supplierModalLabel">Add Supplier</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </button>
            </div>
            <div class="modal-body">
            <!-- Form content here -->
            <form method="POST">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label">Name <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter supplier name" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="services" class="col-md-4 col-form-label">Services <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <!-- Updated Select with multiple attribute -->
                        <select name="services[]" id="services" class="form-control" multiple="multiple" required>
                            <option value="">Select service(s)</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gstin" class="col-md-4 col-form-label">GST No.</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="gstin" name="gstin" placeholder="Enter GST no">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="contact" class="col-md-4 col-form-label">Contact </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="contact" name="contact" min="0" placeholder="Contact No">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label">Email</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="contact_person" class="col-md-4 col-form-label">Contact Person</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person name">
                    </div>
                </div>



                {{-- <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label">Address</label>
                    <div class="col-md-8">
                        <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>
                    <div class="col-md-8">
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                    </div>
                </div> --}}

                <!-- Button Group -->
                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
            </div>

        </div>
        </div>
    </div>

    <script>
        function handleBillToChange(event) {
            // Identify which Bill To dropdown triggered the event
            const dropdown = event.target;
            const dropdownIndex = dropdown.id.split('_')[2];

            // Get references to related fields
            const remarkInputdiv = document.getElementById(`bill_to_remark_div_${dropdownIndex}`);
            const remarkInput = document.getElementById(`bill_to_remark_${dropdownIndex}`);
            const companySearch = document.getElementById(`company_search_div_${dropdownIndex}`);
            const otherSearch = document.getElementById(`other_search_div_${dropdownIndex}`);
            const customerName = document.getElementById('customer_search').value;

            // Reset fields
            remarkInput.value = '';

            // Show or hide fields and enable/disable input based on selection
            switch (dropdown.value) {
                case 'self':
                    companySearch.classList.add('d-none');
                    otherSearch.classList.add('d-none');
                    remarkInputdiv.classList.remove('d-none');
                    remarkInput.readOnly = true;
                    remarkInput.value = customerName; // Set customer name in remark
                    break;

                case 'company':
                    companySearch.classList.remove('d-none');
                    otherSearch.classList.add('d-none');
                    remarkInputdiv.classList.add('d-none');
                    remarkInput.value = '';
                    break;

                case 'other':
                    otherSearch.classList.remove('d-none');
                    companySearch.classList.add('d-none');
                    remarkInputdiv.classList.add('d-none');
                    remarkInput.value = '';
                    break;

                default:
                    remarkInputdiv.classList.add('d-none');
                    remarkInput.value = '';
                    break;
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

             // Set a JavaScript variable based on role check
            const canBackdate = @json(Auth::user()->can('admin') || Auth::user()->can('manager'));

            if (canBackdate) {
                // Allow backdated entries by removing the min date
                bookingDateInput.removeAttribute('min');
            } else {
                // Restrict to today and future dates for other users
                bookingDateInput.setAttribute('min', yesterdayStr);
            }

            bookingDateInput.removeAttribute('max'); // Allow future dates


            let serviceIndex = 1;
            const serviceDropdown = document.getElementById('service_id');
            const tcsContainer = document.getElementById('tcs_container');

            // Event listener for service selection
            serviceDropdown.addEventListener('change', function() {

                var serviceId = $(this).val();

                const selectedOption = serviceDropdown.options[serviceDropdown.selectedIndex];
                const serviceName = selectedOption.getAttribute('data-name');

                // Check if the selected service name contains the word "International"
                if (serviceName && serviceName.toLowerCase().includes('international')) {
                    tcsContainer.classList.remove('d-none');
                } else {
                    tcsContainer.classList.add('d-none');
                }

            });


            const passengerCountInput = document.getElementById('passenger_count_number');
            const passengersTableBody = document.getElementById('passengers-table-body');
            const passengersContainer = document.getElementById('passengers-container');

            let customerRowExists = false; // To track if the customer's row has been added


            function updatePassengerCount() {
                const rows = passengersTableBody.querySelectorAll('tr');
                passengerCountInput.value = rows.length; // Update the count input to reflect current rows
            }

            // Event listener for passenger count changes
            passengerCountInput.addEventListener('input', function() {
                const count = parseInt(passengerCountInput.value, 10);
                // Prevent passenger count from going below 1
                if (count < 1) {
                    passengerCountInput.value = 1;
                    count = 1; // Ensure the minimum value is always 1
                }

                const currentRows = passengersTableBody.querySelectorAll('tr').length;

                // If count is greater than the number of rows (add rows)
                if (Number.isInteger(count) && count > 0 && count > currentRows) {
                    passengersContainer.classList.remove('d-none');

                    // Generate new rows only for additional passengers
                    for (let i = currentRows; i < count; i++) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${i + 1}</td>
                            <td><input type="text" name="passengers[${i}][name]" class="form-control" required></td>
                            <td>
                                <select name="passengers[${i}][gender]" class="form-select form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm cancel-row">Cancel</button></td>
                        `;
                        passengersTableBody.appendChild(row);
                    }
                } else if (count < currentRows) {
                    // If count is reduced, remove extra rows
                    for (let i = currentRows - 1; i >= count; i--) {
                        passengersTableBody.deleteRow(i);
                    }
                }

                updatePassengerCount(); // Update count display
            });

            // Function to handle cancel button click
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('cancel-row')) {
                    event.target.closest('tr').remove();
                    updatePassengerCount(); // Update count after row removal
                }
            });

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
                                    <li class="list-group-item" data-id="${customer.id}" data-gender="${customer.gender}" data-name="${customer.fname} ${customer.lname}" data-whatsapp="${customer.whatsapp}">
                                        ${customer.fname} ${customer.lname}
                                    </li>
                                `);
                                });

                                $('#customer_results').show();
                            } else {
                                $('#customer_results').append(`
                                <li class="list-group-item disabled text-danger d-flex justify-content-between align-items-center">
                                    <span>Name does not exist</span>
                                </li>
                            `);
                                $('#customer_results').show();
                            }
                        }
                    });
                } else {
                    $('#customer_results').hide();
                }
            });

            // Search for managers
            $('#customer_manager_search').on('input', function() {
                let query = $(this).val();
                let customerId = $('#customer_id').val();
                if (query.length >= 2) { // Start searching after 2 characters
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
                    let customerGender = $(this).data('gender');
                    let whatsapp = $(this).data('whatsapp');

                    if (whatsapp === null || whatsapp === undefined || whatsapp === '') {
                        $('#have_has_manager').val('1');
                    }

                    $('#customer_search').val(customerName);
                    $('#customer_id').val(customerId);
                    $('#manager_customer_id').val(customerId);
                    $('#company_customer_id').val(customerId);
                    $('#customer_results').hide();
                    //loadCustomerManager(customerId);

                     // Clear existing rows from the passengers table
                    passengersTableBody.innerHTML = '';

                        const customerRow = `
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="passengers[0][name]" class="form-control" value="${customerName}" required readonly></td>
                                <td>
                                    <select name="passengers[0][gender]" class="form-select form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" ${customerGender === 'Male' ? 'selected' : ''}>Male</option>
                                        <option value="Female" ${customerGender === 'Female' ? 'selected' : ''}>Female</option>
                                        <option value="Other" ${customerGender === 'Other' ? 'selected' : ''}>Other</option>
                                    </select>


                                </td>
                                <td><button type="button" class="btn btn-danger btn-sm cancel-row">Cancel</button></td>
                            </tr>
                        `;
                        // Append the new customer row
                        passengersTableBody.insertAdjacentHTML('beforeend', customerRow);
                        passengersContainer.classList.remove('d-none');

                        updatePassengerCount();
            });

            // Select manager from dropdown
            $('#manager_results').on('click', 'li:not(.disabled)', function() {
                let managerId = $(this).data('id');
                let managerName = $(this).data('name');
                $('#customer_manager_search').val(managerName);
                $('#customer_manager_id').val(managerId);
                $('#manager_results').hide();
            });

            // Optional: Load manager for the selected customer
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

            // Use a common class for the other search input fields
            $(document).on('input', 'input[id^="other_search_"]', function() {
                let query = $(this).val();
                // Extract the index from the ID
                let index = $(this).attr('id').split('_')[2]; // Get the index from 'other_search_1', 'other_search_2', etc.
                let resultsContainer = $('#other_results_' + index); // Get the corresponding results container

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route('customers.search') }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            resultsContainer.empty();
                            if (response.customers.length > 0) {
                                response.customers.forEach(function(customer) {
                                    resultsContainer.append(`
                                        <li class="list-group-item" data-id="${customer.id}" data-name="${customer.fname} ${customer.lname}">
                                            ${customer.fname} ${customer.lname}
                                        </li>
                                    `);
                                });
                                resultsContainer.show();
                            } else {
                                resultsContainer.append(`
                                    <li class="list-group-item disabled text-danger d-flex justify-content-between align-items-center">
                                        <span>Name does not exist</span>
                                    </li>
                                `);
                                resultsContainer.show();
                            }
                        }
                    });
                } else {
                    resultsContainer.hide();
                }
            });

            // Handle click events for the results
            $(document).on('click', 'ul[id^="other_results_"] li:not(.disabled)', function() {
                let customerId = $(this).data('id');
                let customerName = $(this).data('name');
                // Extract the index from the closest input field
                let index = $(this).closest('.service-details-group').find('input[id^="other_search_"]').attr('id').split('_')[2];

                // Update the corresponding search input
                $('#other_search_' + index).val(customerName);
                $('#bill_to_remark_' + index).val(customerName);

                // Hide the results
                $('#other_results_' + index).hide();
            });

            // Use a common class for the company search input fields
            $(document).on('input', 'input[id^="company_search_"]', function() {
                let query = $(this).val();

                let index = $(this).attr('id').split('_')[2];
                let resultsContainer = $('#company_results_' + index);

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route('companies.search') }}',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            resultsContainer.empty();
                            if (response.companies.length > 0) {
                                response.companies.forEach(function(company) {
                                    resultsContainer.append(`
                                        <li class="list-group-item" data-name="${company.name}">
                                            ${company.name}
                                        </li>
                                    `);
                                });
                                resultsContainer.show();
                            } else {
                                resultsContainer.append(`
                                    <li class="list-group-item disabled text-danger d-flex justify-content-between align-items-center">
                                        <span>Name does not exist</span>
                                    </li>
                                `);
                                resultsContainer.show();
                            }
                        }
                    });
                } else {
                    resultsContainer.hide();
                }
            });

            // Handle click events for the results
            $(document).on('click', 'ul[id^="company_results_"] li:not(.disabled)', function() {

                let companyName = $(this).data('name');
                // Extract the index from the closest input field
                let index = $(this).closest('.service-details-group').find('input[id^="company_search_"]').attr('id').split('_')[2];

                // Update the corresponding search input
                $('#company_search_' + index).val(companyName);
                $('#bill_to_remark_' + index).val(companyName);

                // Hide the results
                $('#company_results_' + index).hide();
            });

            // Use a common class for the supplier search input fields
            let timeout = null;
            $(document).on('input', 'input[id^="supplier_search_"]', function() {
                clearTimeout(timeout);

                let query = $(this).val();
                let index = $(this).attr('id').split('_')[2];
                let resultsContainer = $('#supplier_results_' + index);
                let serviceId = $('#service_id').val();
                console.log(index);

                if (query.length >= 2) {
                    timeout = setTimeout(function() {
                        $.ajax({
                            url: '/get-suppliers/' + serviceId,
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                query: query
                            },
                            success: function(response) {
                                resultsContainer.empty();
                                if (response.suppliers.length > 0) {
                                    response.suppliers.forEach(function(supplier) {
                                        resultsContainer.append(`
                                            <li class="list-group-item" data-id="${supplier.id}" data-name="${supplier.name}">
                                                ${supplier.name}
                                            </li>
                                        `);
                                    });
                                    resultsContainer.show();
                                } else {
                                    resultsContainer.append(`
                                        <li class="list-group-item disabled text-danger d-flex justify-content-between align-items-center">
                                            <span>Name does not exist</span>
                                        </li>
                                    `);
                                    resultsContainer.show();
                                }
                            }
                        });
                    }, 300); // 300ms delay for debounce
                } else {
                    resultsContainer.hide();
                }
            });

            // Handle click events for the results
            $(document).on('click', 'ul[id^="supplier_results_"] li:not(.disabled)', function() {
                let supplierId = $(this).data('id');
                let supplierName = $(this).data('name');
                // Extract the index from the closest input field
                let index = $(this).closest('.service-details-group').find('input[id^="supplier_search_"]').attr('id').split('_')[2];

                // Update the corresponding search input
                $('#supplier_search_' + index).val(supplierName);
                $('#supplier_id_' + index).val(supplierId);

                // Hide the results
                $('#supplier_results_' + index).hide();
            });

            // For Customer modal
            const phoneInputField = document.querySelector("#mobile");
            const whatsappInputField = document.querySelector("#whatsapp");

            const phoneInput = window.intlTelInput(phoneInputField, {
                separateDialCode: true,
                preferredCountries: ["in", "us", "uk"],
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            const whatsappInput = window.intlTelInput(whatsappInputField, {
                separateDialCode: true,
                preferredCountries: ["in", "us", "uk"],
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            let whatsappEdited = false;

            phoneInputField.addEventListener("input", function() {
                if (!whatsappEdited) {
                    whatsappInputField.value = phoneInputField.value;
                }
            });

            // Detect user edits on the WhatsApp field
            whatsappInputField.addEventListener("input", function() {
                whatsappEdited = true;
            });

            //For manager mobile and whatsapp
            const manager_phoneInputField = document.querySelector("#manager_mobile");
            const manager_whatsappInputField = document.querySelector("#manager_whatsapp");

            const manager_phoneInput = window.intlTelInput(manager_phoneInputField, {
                separateDialCode: true,
                preferredCountries: ["in", "us", "uk"],
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            const manager_whatsappInput = window.intlTelInput(manager_whatsappInputField, {
                separateDialCode: true,
                preferredCountries: ["in", "us", "uk"],
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            let mgr_whatsappEdited = false;

            manager_phoneInputField.addEventListener("input", function() {
                if (!mgr_whatsappEdited) {
                    manager_whatsappInputField.value = manager_phoneInputField.value;
                }
            });

            // Detect user edits on the WhatsApp field
            manager_whatsappInputField.addEventListener("input", function() {
                whatsappEdited = true;
            });


            $('#customerForm').on('submit', function (e) {
                document.getElementById('customerFormSubmit').disabled = true;
                e.preventDefault();

                if (validateCustomerForm()) {

                    let formData = $(this).serialize(); // Serialize form data

                    $.ajax({
                        url: "{{ route('customers.storeforbooking') }}",
                        type: "POST",
                        data: formData,
                        success: function (response) {
                            if (response.success) {

                                console.log(response);
                                const customerName = response.customer_name;
                                const customerGender = response.customer_gender;
                                const customerId = response.customer_id;
                                const have_has_manager = response.have_manager;

                                $('#customer_search').val(customerName);
                                $('#customer_id').val(customerId);
                                $('#manager_customer_id').val(customerId);
                                $('#company_customer_id').val(customerId);
                                $('#have_has_manager').val(have_has_manager);
                                $('#customer_results').hide();

                                // Optionally, you can show a success message or reset the form
                                $('#customerForm')[0].reset();
                                $('#customerModal').modal('hide');
                                // alert('Customer added successfully.')''

                                $('#add-customer-btn').hide();
                                $('#customer_search').removeClass('me-2');
                                $('#customer_search').addClass('w-100');
                                //loadCustomerManager(customerId);

                                // Clear existing rows from the passengers table
                                passengersTableBody.innerHTML = '';
                                const customerRow = `
                                        <tr>
                                            <td>1</td>
                                            <td><input type="text" name="passengers[0][name]" class="form-control" value="${customerName}" required readonly></td>
                                            <td>
                                                <select name="passengers[0][gender]" class="form-select form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" ${customerGender === 'Male' ? 'selected' : ''}>Male</option>
                                                    <option value="Female" ${customerGender === 'Female' ? 'selected' : ''}>Female</option>
                                                    <option value="Other" ${customerGender === 'Other' ? 'selected' : ''}>Other</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn btn-danger btn-sm cancel-row">Cancel</button></td>
                                        </tr>
                                    `;
                                    // Append the new customer row
                                    passengersTableBody.insertAdjacentHTML('beforeend', customerRow);
                                    passengersContainer.classList.remove('d-none');

                                    updatePassengerCount();



                            } else {
                                alert('Something went wrong');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            // Clear previous errors
                            $('small').html('');

                            for (let field in errors) {
                                // Display error message under input fields
                                $('#error-' + field).html(errors[field].join(', '));

                                // Collect all error messages for alert
                                errorMessage += errors[field].join(', ') + '\n';
                            }

                            alert(errorMessage);

                            } else {
                                alert('An error occurred while processing the request');
                            }
                        }
                    });
                }
            });

            // Form validation logic remains the same
            function validateCustomerForm() {
                document.getElementById('fnameError').innerText = '';
                document.getElementById('lnameError').innerText = '';
                document.getElementById('mobileError').innerText = '';
                document.getElementById('whatsappError').innerText = '';

                const fname = document.getElementById('fname').value.trim();
                const lname = document.getElementById('lname').value.trim();

                // const mobile = document.getElementById('mobile').value.trim();
                // const whatsapp = document.getElementById('whatsapp').value.trim();

                let isValid = true;

                if (fname === '') {
                    document.getElementById('fnameError').innerText = 'First Name is required.';
                    isValid = false;
                }

                if (lname === '') {
                    document.getElementById('lnameError').innerText = 'Last Name is required.';
                    isValid = false;
                }

                // if (!/^\d{10}$/.test(mobile)) {
                //     document.getElementById('mobileError').innerText = 'Please enter a valid mobile number.';
                //     isValid = false;
                // }

                // if (!/^\d{10}$/.test(whatsapp)) {
                //     document.getElementById('whatsappError').innerText = 'Please enter a valid mobile number.';
                //     isValid = false;
                // }

                let has_manager = document.getElementById('have_manager').value === "1";
                if(!has_manager){
                    if (phoneInput.isValidNumber()) {
                        const fullMobileNumber = phoneInput.getNumber();
                        phoneInputField.value = fullMobileNumber;
                    } else {
                        isValid = false;
                        document.getElementById('mobileError').innerText = 'Please enter a valid mobile number.';
                    }

                    if (whatsappInput.isValidNumber()) {
                        const fullWhatsAppNumber = whatsappInput.getNumber();
                        whatsappInputField.value = fullWhatsAppNumber;
                    } else {
                        isValid = false;
                        document.getElementById('whatsappError').innerText = 'Please enter a valid mobile number.';
                    }
                }


                // if (phoneInput.isValidNumber()) {
                //     const countryData = phoneInput.getSelectedCountryData();
                //     const fullNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
                //     const nationalNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
                //     console.log("Country Code:", countryData.dialCode);
                //     console.log("Full Number:", fullNumber);
                //     console.log("National Number:", nationalNumber);
                // } else {
                //     console.error("Invalid number");
                // }

                return isValid;
            }

            // Handle final booking form submission
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                // Perform the necessary actions before the form submission

                // document.querySelectorAll('.tab-pane').forEach(function(tab) {
                //     tab.classList.add('active');
                //     tab.style.display = 'block';
                // });
                document.getElementById('submitButton').disabled = true;
                document.querySelectorAll('input[name="net[]"]').forEach(function(input) {
                    if (input.offsetParent === null) { // Field is hidden
                        input.removeAttribute('required');
                    }
                });


                console.log("booking form submitted");

                // Remove empty passenger rows
                const rows = passengersTableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const name = row.querySelector('input[name$="[name]"]').value.trim();
                    const gender = row.querySelector('select[name$="[gender]"]').value.trim();

                    if (!name && !gender) {
                        row.remove();
                    }
                });

                updatePassengerCount();
            });

            // Get today's date
            const today1 = new Date().toISOString().split('T')[0];

            // Set the min attribute for the date inputs
            document.getElementById('travel_date1_1').setAttribute('min', today1);
            document.getElementById('travel_date2_1').setAttribute('min', today1);

            //Event listener for travel Date 1 an dtravel date 2 selction
            document.getElementById('service-details-container').addEventListener('change', function(event) {
                if (event.target.matches('[id^="travel_date1_"]')) {
                    const travelDate1Input = event.target;
                    const travelDate2Input = travelDate1Input.closest('.service-details-group')
                        .querySelector('[id^="travel_date2_"]');

                    if (travelDate2Input) {
                        const selectedDate = new Date(travelDate1Input.value);
                        const minDate = new Date(selectedDate);
                        minDate.setDate(minDate
                            .getDate()); // Allow Travel Date 2 to be the same as Travel Date 1 or later

                        travelDate2Input.min = minDate.toISOString().split('T')[
                            0]; // Set minimum date for Travel Date 2
                        // Optional: Set the current value of Travel Date 2 to be the same as Travel Date 1 if it is before the new min date
                        if (new Date(travelDate2Input.value) < minDate) {
                            travelDate2Input.value = '';
                        }
                    }
                }
            });

            const panInput = document.getElementById('pan_number');
            panInput.addEventListener('input', function() {
                panInput.value = panInput.value.toUpperCase();
            });


            //Has Manager Logic
            let haveManagerCheckbox = document.getElementById("have_manager");
            let mobileField = document.getElementById("mobileField");
            let whatsappField = document.getElementById("whatsappField");
            let emailField = document.getElementById("emailField");

            haveManagerCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    mobileField.style.display = "none";
                    whatsappField.style.display = "none";
                    emailField.style.display = "none";
                    this.value = "1";
                    console.log(haveManagerCheckbox.value);
                } else {
                    mobileField.style.display = "block";
                    whatsappField.style.display = "block";
                    emailField.style.display = "block";
                    this.value = "0";
                }
            });

            $('#customerManagerForm').on('submit', function (e) {
            e.preventDefault();

            if (validateManagerForm()) {

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('customer-managers.storeforbooking') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            const managerName = response.manager_name;
                            const managerId = response.manager_id;

                            $('#customer_manager_search').val(managerName);
                            $('#customer_manager_id').val(managerId);
                            $('#manager_results').hide();

                            // Optionally, you can show a success message or reset the form
                            $('#customerManagerForm')[0].reset();
                            $('#managerModal').modal('hide');
                            alert('Customer Manager added successfully.');

                            $('#add-manager-btn').hide();
                            $('#customer_manager_search').removeClass('me-2');
                            $('#customer_manager_search').addClass('w-100');

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr) {
                        // Handle error
                        console.error(xhr.responseText);
                        alert('An error occurred while processing the request');
                    }
                });
            }
        });

        function validateManagerForm() {

            document.getElementById('manager_fnameError').innerText = '';
            document.getElementById('manager_lnameError').innerText = '';
            document.getElementById('manager_mobileError').innerText = '';
            document.getElementById('manager_whatsappError').innerText = '';
            document.getElementById('manager_genderError').innerText = '';

            // Get form values
            const manager_fname = document.getElementById('manager_fname').value.trim();
            const manager_lname = document.getElementById('manager_lname').value.trim();
            const manager_mobile = document.getElementById('manager_mobile').value.trim();
            const manager_whatsapp = document.getElementById('manager_whatsapp').value.trim();
            const manager_gender = document.getElementById('manager_gender').value.trim();
            const customer_id = document.getElementById('manager_customer_id').value.trim();

            let isValid = true;

            if (customer_id === '') {
                document.getElementById('manager_customer_idError').innerText = 'Please select customer before adding a manager!';
                isValid = false;
            }
            if (manager_fname === '') {
                document.getElementById('manager_fnameError').innerText = 'First Name is required.';
                isValid = false;
            }
            if (manager_lname === '') {
                document.getElementById('manager_lnameError').innerText = 'Last Name is required.';
                isValid = false;
            }
            if (manager_gender === '') {
                document.getElementById('manager_genderError').innerText = 'Select Gender';
                isValid = false;
            }

            if (manager_phoneInput.isValidNumber()) {
                const fullMobileNumber = manager_phoneInput.getNumber();
                manager_phoneInputField.value = fullMobileNumber;
            } else {
                isValid = false;
                document.getElementById('manager_mobileError').innerText = 'Please enter a valid mobile number.';
            }

            if (manager_whatsappInput.isValidNumber()) {
                const fullWhatsAppNumber = manager_whatsappInput.getNumber();
                manager_whatsappInputField.value = fullWhatsAppNumber;
            } else {
                isValid = false;
                document.getElementById('manager_whatsappError').innerText = 'Please enter a valid whatsapp number.';
            }

            return isValid;
        }

         // Apply Select2 on the services and edit services dropdown
         $('#services').select2({
            placeholder: 'Select service(s)',
            allowClear: true,
            width: '100%'
        });

        $('.select2-container--default .select2-selection--single').css({
            'border': '1px solid #ced4da',
            'border-radius': '0.25rem',
            'height': 'calc(1.5em + 0.75rem + 2px)',
            'display': 'flex',
            'align-items': 'center'
        });
        });
    </script>

    <script> //event listener for change in Service selection
        var serviceIndex = 1;
        document.addEventListener('DOMContentLoaded', function() {
            // let serviceIndex = 1;

                // Function to handle adding a new service details group
                document.getElementById('add-service-button').addEventListener('click', function() {

                    serviceIndex++;
                    var selectedServiceId = $('#service_id').val();
                    var selectedServiceOption = document.querySelector('#service_id option:checked');
                    var selectedServiceType = selectedServiceOption ? selectedServiceOption.dataset.name : '';

                    if (selectedServiceType && selectedServiceType.toLowerCase().includes('international')) {
                        selectedServiceType = 'international';
                    }
                    console.log(selectedServiceType);

                    const container = document.getElementById('service-details-container');

                    // Create a new service details group
                    const newServiceDetailsGroup = document.createElement('div');
                    newServiceDetailsGroup.classList.add('row', 'service-details-group', 'mb-3');
                    let innerHTML = `
                        <div class="service-heading mb-3 col col-12">
                            <h4 class="text-info"><b>Service ${serviceIndex}</b></h4>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="service_details_${serviceIndex}">Service Details <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="service_details_${serviceIndex}" name="service_details[]" placeholder="Enter service details"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="travel_date1_${serviceIndex}">Travel Date 1 <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="travel_date1_${serviceIndex}" name="travel_date1[]">
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="travel_date2_${serviceIndex}">Travel Date 2</label>
                                <input type="date" class="form-control" id="travel_date2_${serviceIndex}" name="travel_date2[]">
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="confirmation_number_${serviceIndex}">Confirmation Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="confirmation_number_${serviceIndex}" name="confirmation_number[]" placeholder="Enter confirmation number">
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="gross_amount_${serviceIndex}">Gross Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="gross_amount_${serviceIndex}" name="gross_amount[]" step="0.01">
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="net_${serviceIndex}">Net Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="net_${serviceIndex}" name="net[]" step="0.01" placeholder="Enter net amount">
                                <small id="net_amount_warning" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="service_fees_${serviceIndex}">Service Fees <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="service_fees_${serviceIndex}" name="service_fees[]" step="0.01" placeholder="Enter service fees" readonly>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="mask_fees_${serviceIndex}">Mask Fees <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="mask_fees_${serviceIndex}" name="mask_fees[]" step="0.01" placeholder="Enter mask fees">
                                <small id="mask_fees_warning" class="form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3 col-3 ${selectedServiceType === 'international' ? '' : 'd-none'}" id="tcs_container_${serviceIndex}">
                            <div class="form-group">
                                <label for="tcs_${serviceIndex}">TCS:</label>
                                <input type="number" class="form-control" id="tcs_${serviceIndex}" name="tcs[]" step="0.01" placeholder="Enter TCS amount">
                            </div>
                        </div>

                        <!-- Bill To Dropdown -->
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="bill_to_${serviceIndex}">Bill To <span class="text-danger">*</span></label>
                                <select name="bill_to[]" id="bill_to_${serviceIndex}" class="form-select form-control">
                                    <option value="" disabled selected>Select Billing Option</option>
                                    <option value="self">Self</option>
                                    <option value="company">Company</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <!-- Bill To Remark (Self) -->
                        <div id="bill_to_remark_div_${serviceIndex}" class="mb-3 col-3 d-none">
                            <div class="form-group">
                                <label for="bill_to_remark_${serviceIndex}">Bill To Remark (Self)</label>
                                <input type="text" id="bill_to_remark_${serviceIndex}" name="bill_to_remark[]" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- Company Search Input -->
                        <div id="company_search_div_${serviceIndex}" class="form-group mb-3 col-3 d-none">
                            <label for="company_search_${serviceIndex}" class="form-label">Search Company</label>
                            <div class="d-flex align-items-center position-relative">
                                <input type="text" id="company_search_${serviceIndex}" class="form-control me-2" placeholder="Search for a company">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#companyModal" data-index="${serviceIndex}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <ul id="company_results_${serviceIndex}" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                                    <!-- Search results will be appended here -->
                                </ul>
                            </div>
                        </div>
                        <!-- Other Search Input -->
                        <div id="other_search_div_${serviceIndex}" class="form-group mb-3 col-3 d-none">
                            <label for="other_search_${serviceIndex}" class="form-label">Search Other</label>
                            <div class="d-flex align-items-center position-relative">
                                <input type="text" id="other_search_${serviceIndex}" class="form-control me-2" placeholder="Search for other customer">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#otherModal" data-index="${serviceIndex}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <ul id="other_results_${serviceIndex}" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                                    <!-- Search results will be appended here -->
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="card_id_${serviceIndex}">Credit Card </label>
                                <select id="card_id_${serviceIndex}" name="card_id[]" class="form-select form-control">
                                    <option value="">Select Card</option>
                                    @foreach ($cards as $card)
                                        <option value="{{ $card->id }}">{{ $card->card_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-3">
                            <div class="form-group">
                                <label for="supplier_id_${serviceIndex}">Supplier <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center position-relative">
                                    <input type="text" id="supplier_search_${serviceIndex}" class="form-control me-2" placeholder="Search for supplier">
                                    <button type="button" id="add_supplier${serviceIndex}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#supplierModal" data-index="${serviceIndex}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <ul id="supplier_results_${serviceIndex}" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                                        <!-- Search results will be appended here -->
                                    </ul>
                                    <input type="hidden" id="supplier_id_${serviceIndex}" name="supplier_id[]">
                                </div>
                            </div>
                        </div>

                    `;

                    // Set the inner HTML of the new service details group
                    newServiceDetailsGroup.innerHTML = innerHTML;

                    container.appendChild(newServiceDetailsGroup);


                    // Show the cancel button for newly added groups
                    const serviceGroups = document.querySelectorAll('.service-details-group');

                    document.getElementById('cancel-service-button').classList.remove('d-none');

                    // Attach the event listener to the new Bill To dropdown
                    document.getElementById(`bill_to_${serviceIndex}`).addEventListener('change', handleBillToChange);
                });


                document.getElementById('cancel-service-button').addEventListener('click', function() {
                    var serviceGroups = document.querySelectorAll('.service-details-group');

                    if (serviceGroups.length > 1) {

                        serviceGroups[serviceGroups.length - 1].remove();
                    }

                    serviceGroups = document.querySelectorAll('.service-details-group');
                    if (serviceGroups.length === 1) {
                            document.getElementById('cancel-service-button').classList.add('d-none');
                    }
                    serviceIndex--;
                });

            // Function to calculate service fees
            function calculateServiceFees() {
                console.log("calclate service fees.....");
                document.querySelectorAll('.service-details-group').forEach(function(group) {
                    const grossAmountInput = group.querySelector('[id^="gross_amount_"]');
                    const netAmountInput = group.querySelector('[id^="net_"]');
                    const serviceFeesInput = group.querySelector('[id^="service_fees_"]');
                    const maskFeesInput = group.querySelector('[id^="mask_fees_"]');
                    //const billAmountInput = group.querySelector('[id^="bill_"]');
                    const netAmountWarning = group.querySelector('[id^="net_amount_warning"]');
                    const maskFeesWarning = group.querySelector('[id^="mask_fees_warning"]');

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
                });
            }

            // Function to update date restrictions
            function updateDateRestrictions() {
                document.querySelectorAll('.service-details-group').forEach(function(group) {
                    const travelDate1Input = group.querySelector('[id^="travel_date1_"]');
                    const travelDate2Input = group.querySelector('[id^="travel_date2_"]');

                    if (travelDate1Input && travelDate2Input) {
                        const travelDate1Value = travelDate1Input.value;
                        if (travelDate1Value) {
                            travelDate2Input.setAttribute('min', travelDate1Value);
                        } else {
                            travelDate2Input.removeAttribute('min');
                        }
                    }
                });
            }

            function checkBillAmount() {
                console.log("bill amount checking.....");
                document.querySelectorAll('.service-details-group').forEach(function(group) {
                    const netAmountInput = group.querySelector('[id^="net_"]');
                    const billAmountInput = group.querySelector('[id^="bill_"]');
                    const billAmountWarning = group.querySelector('[id^="bill_amount_warning"]');

                    if (!netAmountInput || !billAmountInput) {
                        return;
                    }
                    const netAmount = parseFloat(netAmountInput.value) || 0;
                    const billAmount = parseFloat(billAmountInput.value) || 0;

                    // if (billAmount < netAmount) {
                    //     billAmountWarning.textContent = "Bill amount cannot be less than Net amount.";
                    //     return;
                    // }
                    // billAmountWarning.textContent = '';
                });
            }

            let debounceTimer;

            // Event listener for net amount or mask fees input changes
            document.addEventListener('input', function(event) {
                if (event.target.matches('[id^="net_"]') || event.target.matches('[id^="mask_fees_"]') || event.target.matches('[id^="gross_"]') ) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function() {
                        calculateServiceFees();
                    }, 500);
                } else if (event.target.matches('[id^="travel_date1_"]')) {
                    updateDateRestrictions();
                }
                    // else if (event.target.matches('[id^="bill_"]')) {
                    //     checkBillAmount();
                    // }
            });


            // Initial setup for existing inputs
            updateDateRestrictions();
        });


        let billToRemarkIndex = null;
        let supplierIndex = null;

        // Attach the event listener to a parent container that exists when the page loads
        document.getElementById('service-details-container').addEventListener('click', function(event) {
            //Check if the clicked element is a button that opens the company modal
            console.log("Clicked element:", event.target);
            billToRemarkIndex = serviceIndex;
            console.log("Bill to remark index = " + billToRemarkIndex);

            // if (event.target.matches('button[data-bs-target="#companyModal"]')) {
            //     const clickedButton = event.target.closest('button');
            //     billToRemarkIndex = clickedButton.getAttribute('data-index');
            //     billToRemarkIndex = serviceIndex;

            //     console.log("Button index = " + billToRemarkIndex);
            // }

            // if (event.target.matches('button[data-bs-target="#otherModal"]')) {
            //     const clickedButton = event.target.closest('button');
            //     billToRemarkIndex = clickedButton.getAttribute('data-index');
            //     console.log("Button index = " + billToRemarkIndex);
            // }

            if (event.target.matches('button[data-bs-target="#supplierModal"]')) {
                const clickedButton = event.target.closest('button');
                supplierIndex = clickedButton.getAttribute('data-index');
                console.log("Supplier Button index = " + supplierIndex);
            }
        });

        // Event listener for the Save Company button
        document.getElementById('saveCompanyButton').addEventListener('click', function() {

            clearCompanyErrors();

            // Validate Add company form
            const errors = validateCompanyForm();
            if (errors.length > 0) {
                errors.forEach(error => {
                    document.getElementById(error.field + 'Error').innerText = error.message;
                });
                return;
            }

            const customer_id = document.getElementById('company_customer_id').value;
            const company_name = document.getElementById('company_name').value;
            const company_mobile = document.getElementById('company_mobile').value;
            const company_gst = document.getElementById('company_gst').value;
            const company_address = document.getElementById('company_address').value;

            $.ajax({
                url: '/save-bookingcompany',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    company_name: company_name,
                    company_mobile: company_mobile,
                    company_gst: company_gst,
                    company_address: company_address,
                    customer_id: customer_id
                },
                success: function(data) {
                    if (data.success) {
                        $('#company_name').val('');
                        $('#company_mobile').val('');
                        $('#company_gst').val('');
                        $('#company_address').val('');

                        console.log('billToRemarkIndex:' + billToRemarkIndex);
                        if (billToRemarkIndex !== null) {
                            document.getElementById(`bill_to_remark_${billToRemarkIndex}`).value = data.company_name;
                            company = document.getElementById(`bill_to_remark_${billToRemarkIndex}`).value;
                            document.getElementById(`company_search_${billToRemarkIndex}`).value = company;
                            console.log("input:" + company);
                        }
                        // billToRemarkIndex = null;
                        $('#companyModal').modal('hide');
                        // alert(data.message);
                    } else {
                        alert(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('An error occurred while saving the company.');
                }
            });
        });


        function validateCompanyForm() {
            const errors = [];

            const customer_id = document.getElementById('company_customer_id').value.trim();
            const company_name = document.getElementById('company_name').value.trim();
            const company_mobile = document.getElementById('company_mobile').value.trim();
            const company_gst = document.getElementById('company_gst').value.trim();
            const company_address = document.getElementById('company_address').value.trim();

            if (customer_id === '') {
                errors.push({ field: 'company_customer_id', message: 'Please select customer before adding a company!' });
            }

            if (company_name === '') {
                errors.push({ field: 'company_name', message: 'Company Name is required.' });
            }

            // if (company_mobile === '' || !/^\d{10}$/.test(company_mobile)) {
            //     errors.push({ field: 'company_mobile', message: 'Mobile number must be exactly 10 digits.' });
            // }

            // if (company_gst === '') {
            //     errors.push({ field: 'company_gst', message: 'GST Number is required.' });
            // }

            // if (company_address === '') {
            //     errors.push({ field: 'company_address', message: 'Address is required.' });
            // }

            return errors;
        }

        // Function to clear error messages
        function clearCompanyErrors() {
            document.getElementById('company_customer_idError').innerText = '';
            document.getElementById('company_nameError').innerText = '';
            document.getElementById('company_mobileError').innerText = '';
            document.getElementById('company_gstError').innerText = '';
            document.getElementById('company_addressError').innerText = '';
        }

            const ophoneInputField = document.querySelector("#omobile");
            const owhatsappInputField = document.querySelector("#owhatsapp");

            const ophoneInput = window.intlTelInput(ophoneInputField, {
                separateDialCode: true,
                preferredCountries: ["in", "us", "uk"],
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            const owhatsappInput = window.intlTelInput(owhatsappInputField, {
                separateDialCode: true,
                preferredCountries: ["in", "us", "uk"],
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

        let owhatsappEdited = false;

        ophoneInputField.addEventListener("input", function() {
            if (!owhatsappEdited) {
                owhatsappInputField.value = ophoneInputField.value;
            }
        });

        // Detect user edits on the WhatsApp field
        owhatsappInputField.addEventListener("input", function() {
            owhatsappEdited = true;
        });

        $('#otherCustomerForm').on('submit', function (e) {
            e.preventDefault();

            if (validateOtherCustomerForm()) {

                let formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: "{{ route('customers.storeforbooking') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            const customerName = response.customer_name;

                            console.log(billToRemarkIndex);
                        if (billToRemarkIndex !== null) {
                            document.getElementById(`bill_to_remark_${billToRemarkIndex}`).value = customerName;

                            document.getElementById(`other_search_${billToRemarkIndex}`).value = customerName;
                            console.log("input:" + customerName);
                        }

                            $('#otherModal').modal('hide');
                            billToRemarkIndex = null;

                            // alert('Customer added successfully.');

                        } else {
                            alert(response.message || 'Something went wrong');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Parse and display validation errors
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessages += `${errors[key].join(', ')}\n`;
                                }
                            }

                            alert(errorMessages || 'Validation failed. Please check your inputs.');
                        } else {
                            console.error(xhr.responseText);
                            alert('An error occurred while processing the request');
                        }
                    }
                });
            }
        });

        function validateOtherCustomerForm() {
            console.log("test")
            document.getElementById('ofnameError').innerText = '';
            document.getElementById('olnameError').innerText = '';
            document.getElementById('omobileError').innerText = '';
            document.getElementById('owhatsappError').innerText = '';

            const ofname = document.getElementById('ofname').value.trim();
            const olname = document.getElementById('olname').value.trim();


            let isValid = true;

            if (ofname === '') {
                document.getElementById('ofnameError').innerText = 'First Name is required.';
                isValid = false;
            }

            if (olname === '') {
                document.getElementById('olnameError').innerText = 'Last Name is required.';
                isValid = false;
            }

            if (ophoneInput.isValidNumber()) {
                    const fullMobileNumber = ophoneInput.getNumber();
                    console.log("Full Mobile Number:", fullMobileNumber);
                    ophoneInputField.value = fullMobileNumber;
                } else {
                    isValid = false;
                    document.getElementById('omobileError').innerText = 'Please enter a valid mobile number.';
                }

                if (owhatsappInput.isValidNumber()) {
                    const fullWhatsAppNumber = owhatsappInput.getNumber();
                    console.log("Full WhatsApp Number:", fullWhatsAppNumber);
                    owhatsappInputField.value = fullWhatsAppNumber;
                } else {
                    isValid = false;
                    document.getElementById('owhatsappError').innerText = 'Please enter a valid mobile number.';
                }



            return isValid;
        }

            //add supplier modal
            const form = document.querySelector('#supplierModal form');
            //Supplier modal form submit
            form.addEventListener('submit', function (event) {
                let valid = true;
                console.log("create supplier submitted");
                const name = document.getElementById('name');
                const gstin = document.getElementById('gstin');
                const contact = document.getElementById('contact');
                const email = document.getElementById('email');
                const contactPerson = document.getElementById('contact_person');
                const services = document.getElementById('services');

                event.preventDefault();

                clearErrors();

                if (name.value.trim() === '') {
                    showError(name, 'Supplier Name is required');
                    valid = false;
                }

                if (services.selectedOptions.length === 0) {
                    showError(services, 'At least one service must be selected');
                    valid = false;
                }

                // if (gstin.value.trim() === '') {
                //     showError(gstin, 'GST No is required');
                //     valid = false;
                // }

                // if (contactPerson.value.trim() === '') {
                //     showError(contactPerson, 'Contact person name is required');
                //     valid = false;
                // }

                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                const emailID = email.value.trim();
                if (emailID && !emailPattern.test(emailID)) {
                    showError(email, 'Valid Email is required');
                    valid = false;
                }


                const mobileValue = contact.value.trim();
                if (mobileValue && (mobileValue.length !== 10 || !/^\d{10}$/.test(mobileValue))) {
                    showError(contact, 'Mobile Number must be exactly 10 digits long');
                    valid = false;
                }

                if (!valid) {
                    return;
                }else{

                    const submitButton = document.querySelector('button[type="submit"]');
                    submitButton.disabled = true;

                    let formData = $(form).serialize();

                    $.ajax({
                        url: "{{ route('suppliers.store') }}",
                        type: "POST",
                        data: formData,
                        success: function (response) {
                            if (response.success) {
                            const supplierName = response.name;
                            const supplierId = response.id;

                            console.log(supplierIndex);
                        if (supplierIndex !== null) {
                            document.getElementById(`supplier_search_${supplierIndex}`).value = supplierName;
                            document.getElementById(`supplier_id_${supplierIndex}`).value = supplierId;
                        }

                            $('#supplierModal').modal('hide');
                            supplierIndex = null;
                            // alert('Customer added successfully.');

                        } else {
                            alert('Something went wrong');
                        }
                        },

                        error: function (xhr) {
                            let message = 'An error occurred.';
                            if (xhr.status === 422) {
                                message = 'Validation error. Please check your inputs.';
                            } else if (xhr.status === 500) {
                                message = 'Server error. Please try again later.';
                            } else if (xhr.status === 404) {
                                message = 'Requested resource not found.';
                            } else if (xhr.status === 419) {
                                message = 'Session expired. Please refresh the page.';
                            } else if (xhr.status === 409) {
                                message = 'A supplier with the same name already exists.';
                            }
                            console.error(xhr.responseText);
                            alert(message);
                        }
                    });

                }

            });

            function showError(input, message) {
                const errorElement = document.createElement('div');
                errorElement.className = 'text-danger';
                errorElement.textContent = message;
                input.closest('.col-md-8').appendChild(errorElement);
            }

            function clearErrors() {
                const errorMessages = document.querySelectorAll('.text-danger');
                errorMessages.forEach(function (element) {
                    element.remove();
                });
            }

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Attach the change event handler to all Bill To dropdowns
            document.querySelectorAll('[id^="bill_to_"]').forEach(function(dropdown) {
                dropdown.addEventListener('change', handleBillToChange);
            });

            var countrySelect = document.getElementById('country_id');
            var stateSelect = document.getElementById('state_id');
            var citySelect = document.getElementById('city_id');

            let countrycontroller = new AbortController();
            let controller = new AbortController();

            countrySelect.addEventListener('change', function() {
                var countryId = this.value;

                // Clear current state and city options
                stateSelect.innerHTML = '<option value="">Select State</option>';
                citySelect.innerHTML = '<option value="">Select City</option>';

                countrycontroller.abort();
                countrycontroller = new AbortController();

                if (countryId) {
                    fetch('/get-states/' + countryId, { signal: countrycontroller.signal })
                        .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(function(data) {
                            // Populate state dropdown with fetched states
                            data.forEach(function(state) {
                                var option = document.createElement('option');
                                option.value = state.id;
                                option.textContent = state.name;
                                stateSelect.appendChild(option);
                            });
                        })
                        .catch(function(error) {
                            if (error.name === 'AbortError') {
                                console.log('Fetch request was aborted');
                            } else {
                                console.error('There was a problem with the fetch operation:', error);
                            }
                        });
                }
            });

            stateSelect.addEventListener('change', function() {
                var stateId = this.value;

                citySelect.innerHTML = '<option value="">Select City</option>';

                controller.abort();
                controller = new AbortController();

                if (stateId) {
                    fetch('/get-cities/' + stateId, { signal: controller.signal })
                        .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(function(data) {
                            data.forEach(function(city) {
                                var option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                        })
                        .catch(function(error) {
                            if (error.name === 'AbortError') {
                                console.log('Fetch request was aborted');
                            } else {
                                console.error('There was a problem with the fetch operation:', error);
                            }
                        });
                }
            });

        });
    </script>

    <script>  // Tab validations
        function nextTab(nextIndex) {
            console.log( "Tab = " + nextIndex + "button clicked");
            if (validateForm(nextIndex)) {
                var tabList = new bootstrap.Tab(document.querySelectorAll('#tabMenu .nav-link')[nextIndex]);
                tabList.show();

                if (nextIndex === 3) {
                    checkIfEnableSubmit();
                }
            }
        }

        function previousTab(previousIndex) {
            var tabList = new bootstrap.Tab(document.querySelectorAll('#tabMenu .nav-link')[previousIndex]);
            tabList.show();
        }

        function validateForm(tabIndex) {
            console.log("Tab index : " + tabIndex);
            let isValid = true;

            // Clear all previous error messages
            clearErrors();

            // Validate fields based on the current tab index
            if (tabIndex === 1) {
                // Validate fields on tab 1
                const bookingDateInput = document.getElementById('booking_date');
                const bookingDateError = document.getElementById('booking_date_error');
                const bookingDate = document.getElementById('booking_date').value;

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const yesterday = new Date(today);
                yesterday.setDate(today.getDate() - 1);

                const canBackdate = @json(Auth::user()->can('admin') || Auth::user()->can('manager'));


                if (!bookingDate) {
                    isValid = false;
                    bookingDateError.innerText = 'Booking Date is required.';
                } else {
                    // Convert input date to Date object
                    const enteredDate = new Date(bookingDate);
                    enteredDate.setHours(0, 0, 0, 0);

                    console.log("entered date : " + enteredDate);
                    console.log("yesterday : " + yesterday);
                    console.log("today : " + today);


                    const formattedYesterday = yesterday.toLocaleDateString('en-GB');
                    const formattedToday = today.toLocaleDateString('en-GB');

                    if (!canBackdate && enteredDate < yesterday) {
                        isValid = false;
                        bookingDateError.innerText = `Booking Date cannot be before ${formattedYesterday}.`;
                    } else if (enteredDate > today) {
                        isValid = false;
                        bookingDateError.innerText = `Booking Date cannot be after ${formattedToday}.`;
                    } else {
                        bookingDateError.innerText = ''; // Clear error if valid
                    }
                }

                const status = document.getElementById('status').value;
                if (!status) {
                    isValid = false;
                    document.getElementById('status_error').innerText = 'Booking Status is required.';
                }

                const service = document.getElementById('service_id').value;
                if (!service) {
                    isValid = false;
                    document.getElementById('service_error').innerText = 'Service is required.';
                }

                const customer = document.getElementById('customer_id').value;
                if (!customer) {
                    isValid = false;
                    document.getElementById('customer_error').innerText = 'Customer is required.';
                }

                const requiresManager = document.getElementById('have_has_manager').value === "1"; // Convert to boolean
                const managerID = document.getElementById('customer_manager_id').value.trim(); // Trim to remove spaces

                if (requiresManager && !managerID) {
                    isValid = false;
                    document.getElementById('customer_manager_error').innerText = 'Manager is required as the customer does not have whatsapp no.';
                } else {
                    document.getElementById('customer_manager_error').innerText = ''; // Clear error if valid
                }



                // Validate Passenger details
                const passengerRows = document.querySelectorAll('#passengers-table-body tr');
                passengerRows.forEach((row, index) => {
                    const nameField = row.querySelector(`input[name="passengers[${index}][name]"]`);
                    const genderField = row.querySelector(`select[name="passengers[${index}][gender]"]`);

                    if (!nameField.value.trim()) {
                        isValid = false;
                        nameField.classList.add('is-invalid');  // Adding error class to the input
                        const errorElement = document.createElement('small');
                        errorElement.classList.add('text-danger');
                        errorElement.innerText = 'Passenger name is required.';
                        nameField.parentElement.appendChild(errorElement);
                    }

                    if (!genderField.value) {
                        isValid = false;
                        genderField.classList.add('is-invalid');
                        const errorElement = document.createElement('small');
                        errorElement.classList.add('text-danger');
                        errorElement.innerText = 'Passenger gender is required.';
                        genderField.parentElement.appendChild(errorElement);
                    }
                });

                return isValid;

            } else if (tabIndex === 2) {
                let isValid = true;
                let serviceGroups = document.querySelectorAll('.service-details-group');
                serviceGroups.forEach((group, index) => {
                    // Clear previous error messages
                    cleargroupErrors(group)


                    let serviceDetails = group.querySelector('textarea[name="service_details[]"]');
                    if (serviceDetails.value.trim() === '') {
                        document.getElementById('booking_date_error').innerText = 'Service details are required.';
                        showError(serviceDetails, 'Service details are required.');
                        isValid = false;
                    }


                    let travelDate1 = group.querySelector('input[name="travel_date1[]"]');
                    if (travelDate1.value.trim() === '') {
                        showError(travelDate1, 'Travel Date 1 is required.');
                        isValid = false;
                    }


                    let confirmationNumber = group.querySelector('input[name="confirmation_number[]"]');
                    if (confirmationNumber.value.trim() === '') {
                        showError(confirmationNumber, 'Confirmation number is required.');
                        isValid = false;
                    }


                    let grossAmount = group.querySelector('input[name="gross_amount[]"]');
                    if (grossAmount.value.trim() === '' || parseFloat(grossAmount.value) <= 0) {
                        showError(grossAmount, 'Gross amount must be greater than 0.');
                        isValid = false;
                    }


                    let netAmount = group.querySelector('input[name="net[]"]');
                    if (netAmount.value.trim() === '') {
                        console.log(netAmount.value.trim());
                        showError(netAmount, 'Net Amount must be valid value.');
                        isValid = false;
                    }


                    let serviceFees = group.querySelector('input[name="service_fees[]"]');
                    //if (serviceFees.value.trim() === '' || parseFloat(serviceFees.value) <= 0) {
                        if (serviceFees.value.trim() === '') {
                        showError(serviceFees, 'Please enter valid service fees.');
                        isValid = false;
                    }

                    let billTo = group.querySelector('select[name="bill_to[]"]');
                    if (billTo.value === '' || billTo.value === null) {
                        showError(billTo, 'Please select a billing option.');
                        isValid = false;
                    }


                    let billToRemark = group.querySelector('input[name="bill_to_remark[]"]');
                    // console.log("Bill to remark " + billToRemark.value.trim()+".");
                        if (billTo.value != '' && billToRemark.value.trim() === '') {
                            let selfDiv = group.querySelector('div[id^="bill_to_remark_div_"]');
                            let selfError = group.querySelector('input[id^="bill_to_remark_"]');
                            let companyDiv = group.querySelector('div[id^="company_search_"]');
                            let companyError = group.querySelector('input[id^="company_search_"]');
                            let otherDiv = group.querySelector('div[id^="other_search_"]');
                            let otherError = group.querySelector('input[id^="other_search_"]');

                            if (!selfDiv.classList.contains('d-none')) {
                                showError(selfError, 'Please provide a remark.');
                            }
                            if (!companyDiv.classList.contains('d-none')) {
                                showError(companyError, 'Please provide a remark.');
                            }
                            if (!otherDiv.classList.contains('d-none')) {
                                showError(otherError, 'Please provide a remark.');
                            }
                            isValid = false;
                        }


                    let supplier = group.querySelector('input[name="supplier_id[]"]');
                    if (supplier.value.trim() === '') {
                        showError(supplier, 'Select the Supplier');
                        isValid = false;
                    }
                });

                return isValid;

            } else if (tabIndex === 3) {
                let isValid = true;
                clearErrors();

                // Payment type validation
                const paymentStatus = document.getElementById('payment_status');
                if (paymentStatus.value === "") {
                    showError(paymentStatus, 'Please select a payment type.');
                    isValid = false;
                }

                // Payment received validation
                const paymentReceivedInput = document.getElementById('payment_received_remark');
                if (paymentReceivedInput.value.trim() === "") {
                    showError(paymentReceivedInput, 'Please enter the payment received remark.');
                    isValid = false;
                }

                // PAN number validation
                // const panInput = document.getElementById('pan_number');
                // const panNumber = panInput.value.trim();
                // const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                // if (panNumber === "" || !panRegex.test(panNumber)) {
                //     showError(panInput, 'Please enter a valid PAN number.');
                //     isValid = false;
                // }

                // Reminder date validation (if filled)
                const reminderInput = document.getElementById('office_reminder');
                const reminderDate = reminderInput.value;
                // if(reminderDate === ""){
                //     showError(reminderInput, 'Please enter a valid reminder date and time.');
                //     isValid = false;
                // }
                if (reminderDate !== "" && isNaN(Date.parse(reminderDate))) {
                    showError(reminderInput, 'Please enter a valid reminder date and time.');
                    isValid = false;
                }

                return isValid;
            }

            return isValid;
        }

        function showError(input, message) {
            let small = document.createElement('small');
            small.classList.add('text-danger');
            small.classList.add('errors');
            small.textContent = message;
            input.closest('.form-group').appendChild(small);
        }

        function clearErrors() {
            // Clear static error messages
            document.querySelectorAll('.errors').forEach((element) => {
                element.innerText = '';
            });

            // Clear dynamic validation error messages for passenger fields
            document.querySelectorAll('.is-invalid').forEach((element) => {
                element.classList.remove('is-invalid');
            });

            // Clear content of dynamically created error messages for passenger fields, without removing the elements
            document.querySelectorAll('small.text-danger').forEach((errorMsg) => {
                // Only clear the content of the error messages
                errorMsg.innerText = '';
            });
        }

        function cleargroupErrors(group) {
            let errors = group.querySelectorAll('.text-danger');
            errors.forEach(error => error.remove());
        }

        function clearPassengerCountErrors() {
            const invalidFields = document.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
                const errorMsg = field.parentElement.querySelector('small.text-danger');
                if (errorMsg) {
                    errorMsg.remove();
                }
            });
        }

        // Enable submit button after all validations
        function checkIfEnableSubmit() {
            const tab1Valid = validateForm(1);
            const tab2Valid = validateForm(2);
            const tab3Valid = validateForm(3);

            if (tab1Valid && tab2Valid && tab3Valid) {
                document.getElementById('submitButton').disabled = false;
            }
        }
    </script>



<script>
    $(document).ready(function () {

    });
</script>
@endsection
