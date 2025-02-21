@extends('layout.app')
@section('title', 'Create Enquiry')
@section('content')
<style>
    .iti{
        display : block;
    }
</style>

</style>

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
                        <h3 class=" font-weight-bold text-primary">Create Enquiry</h3>
                    </div>

                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">  Back </a>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Enquiry Details</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('enquiries.store') }}" method="POST" id="enquiryForm">
                                @csrf
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="mb-3 col col-6">
                                        <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fname" name="fname" value="{{ old('fname') }}" required minlength="2" maxlength="50" pattern="[A-Za-z\s]+" title="First name must contain only letters and spaces" autofocus>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="mb-3 col col-6">
                                        <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lname" name="lname" value="{{ old('lname') }}" required minlength="2" maxlength="50" pattern="[A-Za-z\s]+" title="Last name must contain only letters and spaces">
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="mobile" name="mobile" min="0" value="{{ old('mobile') }}" required>
                                        <small id="mobile-error" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="whatsapp" class="form-label">WhatsApp</label>
                                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp"  min="0" value="{{ old('whatsapp') }}">
                                        <small id="whatsapp-error" class="text-danger"></small>
                                    </div>


                                    <!-- Email -->
                                    <div class="mb-3 col col-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3 col col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" maxlength="255">
                                    </div>

                                    <!-- Source -->
                                    <div class="mb-3 col col-6">
                                        <label for="source_id" class="form-label">Source <span class="text-danger">*</span></label>
                                        <select class="form-control" name="source_id" id="source_id" required>
                                            <option value="" disabled selected>Select Source</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}" @if($source->id == old('source_id')) selected @endif>{{ $source->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                     <!-- Priority -->
                                     <div class="mb-3 col-12 col-md-6">
                                        <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                        <select class="form-control" id="priority" name="priority" required>
                                            <option value="Corporate">Corporate</option>
                                            <option value="Urgent">Urgent(travel within 48Hrs)</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>

                                    <!-- Service Type  multiselect-->
                                    <div class="mb-3 col col-6">
                                        <label for="services" class="form-label">Services <span class="text-danger">*</span></label>
                                        <div class="col" style="padding:0px;">
                                            <select name="services[]" id="services" class="form-control" multiple="multiple" required>
                                                <option value="" disable>Select service(s)</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Assign to employees multiselect  -->
                                    <div class="mb-3 col col-6">
                                        <label for="employee_id" class="form-label">Assign To</label>
                                        <select class="form-control" id="employees" name="employees[]" multiple="multiple">
                                            <option value="" disable>Select employee(s)</option>
                                            @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                        @endforeach
                                        </select>
                                    </div>



                                    {{-- <div class="mb-3 col-12 col-md-6">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="New">New</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Converted">Converted</option>
                                                        <option value="Dead">Dead</option>
                                                    </select>
                                                </div> --}}

                                    <input type="hidden" name="status" value="New">

                                    <!-- Note -->
                                    <div class="mb-3 col-12 col-md-12">
                                        <label for="note" class="form-label">Note</label>
                                        <textarea name="note" id="note" class="form-control" rows="3" maxlength="500">{{ old('note') }}</textarea>
                                    </div>
                                </div>



                    </div>
                    <div class="card-footer mt-4 text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->




        </div>
        <!-- End of Content Wrapper -->

  <!-- End of Page Wrapper -->
  @include('shared.footer')
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



<script>
    $(document).ready(function() {
        // Apply Select2 on the services and edit services dropdown
        $('#services').select2({
            placeholder: 'Select service(s)',
            allowClear: true,
            width: '100%'
        });

        $('#employees').select2({
            placeholder: 'Select employees(s)',
            allowClear: true,
            width: '100%'
        });

    //     document.getElementById('enquiryForm').addEventListener('submit', function(event) {
    //     // Clear previous error messages
    //     document.getElementById('mobile-error').textContent = '';
    //     document.getElementById('whatsapp-error').textContent = '';

    //     const mobile = document.getElementById('mobile');
    //     const whatsapp = document.getElementById('whatsapp');
    //     const mobileRegex = /^\d{10}$/;

    //     let isValid = true;

    //     // Validate mobile number
    //     if (!mobileRegex.test(mobile.value)) {
    //         document.getElementById('mobile-error').textContent = 'Mobile number must be 10 digits.';
    //         isValid = false;
    //     }

    //     // Validate WhatsApp number (if provided)
    //     if (whatsapp.value && !mobileRegex.test(whatsapp.value)) {
    //         document.getElementById('whatsapp-error').textContent = 'WhatsApp number must be 10 digits.';
    //         isValid = false;
    //     }

    //     // Prevent form submission if validation fails
    //     if (!isValid) {
    //         event.preventDefault();
    //     }
    // });
    // });


    // INternational Nos
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

        document.getElementById("enquiryForm").addEventListener("submit", function(e) {
            document.getElementById('mobile-error').textContent = '';
            document.getElementById('whatsapp-error').textContent = '';
            // Validate and set full international mobile number
            if (phoneInput.isValidNumber()) {
                const fullMobileNumber = phoneInput.getNumber();
                console.log("Full Mobile Number:", fullMobileNumber);
                phoneInputField.value = fullMobileNumber;
            } else {
                e.preventDefault();
                document.getElementById('mobile-error').textContent = 'Please enter a valid mobile number.';
            }

            if (whatsappInput.isValidNumber()) {
                const fullWhatsAppNumber = whatsappInput.getNumber();
                console.log("Full WhatsApp Number:", fullWhatsAppNumber);
                whatsappInputField.value = fullWhatsAppNumber;
                return;
            } else {
                e.preventDefault();
                document.getElementById('whatsapp-error').textContent = 'Please enter a valid whatsapp number.';
            }
        });
    });

</script>



@endsection
