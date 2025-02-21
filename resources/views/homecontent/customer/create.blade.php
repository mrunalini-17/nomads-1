@extends('layout.app')
@section('title', 'Create Customer')
@section('content')

<style>
    .iti{
        display : block;
    }
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
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back</a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Customer</h6>
                        </div>
                        <form action="{{ route('customers.store') }}" method="POST" id="customerForm">
                            <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="fname" class="form-label">First Name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" value="{{ old('fname') }}" required>
                                            @error('fname')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="lname" class="form-label">Last Name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" value="{{ old('lname') }}"required>
                                            @error('lname')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="mobile" class="form-label">Mobile <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" min="0" value="{{ old('mobile') }}" required>
                                            @error('mobile')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="whatsapp" class="form-label">WhatsApp <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="tel" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp"  min="0" value="{{ old('whatsapp') }}" required>
                                            @error('whatsapp')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="gender" class="form-label">Gender <span class="text-danger"><sup>*</sup></span></label>
                                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                                <option value="" disabled>Select Gender</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-6">
                                            <label for="locality" class="form-label">Locality</label>
                                            <textarea class="form-control @error('locality') is-invalid @enderror" id="locality" name="locality" rows="1 "value="{{ old('locality') }}"></textarea>
                                            @error('locality')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="number" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" min="0" value="{{ old('pincode') }}" pattern="^\d{6}$">
                                            @error('pincode')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-6">
                                            <div class="form-group">
                                                <label for="country_id">Country</label>
                                                <select class="form-control @error('country_id') is-invalid @enderror"
                                                    id="country_id" name="country_id">
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


                                            <div class="mb-3 col-md-6">
                                                <div class="form-group">
                                                    <label for="state_id">State</label>
                                                    <select class="form-control @error('state_id') is-invalid @enderror"
                                                        id="state_id" name="state_id">
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

                                            <div class="mb-3 col-md-6">
                                                <div class="form-group">
                                                    <label for="city_id">City</label>
                                                    <select class="form-control @error('city_id') is-invalid @enderror"
                                                        id="city_id" name="city_id">
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

                                            <div class="mb-3 col-md-6">
                                                <div class="form-group">
                                                    <label for="reference_id">Reference</label>
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

                                            <div class="mb-3 col-md-6 ml-3">
                                                <div class="form-check">
                                                    <input type="hidden" name="have_manager" value="0">
                                                    <input type="checkbox" class="form-check-input border-3 border-info" id="have_manager" name="have_manager" value="1"
                                                        {{ old('have_manager') == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="have_manager"> Add Manager</label>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6 ml-3">
                                                <div class="form-check">
                                                    <input type="hidden" name="have_company" value="0">
                                                    <input type="checkbox" class="form-check-input border-3 border-info" id="have_company" name="have_company" value="1"
                                                        {{ old('have_company') == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="have_company"> Add Company</label>
                                                </div>
                                            </div>

                                    </div>

                                    <div class="row d-none" id="manager_information">
                                        <!-- Manager Information Form Fields -->
                                        <div class="col-12 card-header py-3 mb-3">
                                            <h6 class="font-weight-bold text-primary">Manager Details</h6>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="fname" class="form-label">First Name  <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="manager_fname" name="manager_fname">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="lname" class="form-label">Last Name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="manager_lname" name="manager_lname">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_mobile" class="form-label">Mobile <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="number" class="form-control" id="manager_mobile" name="manager_mobile"min="0">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_whatsapp" class="form-label">WhatsApp <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="number" class="form-control" id="manager_whatsapp" name="manager_whatsapp" min="0">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="manager_email" name="manager_email">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_position" class="form-label">Position</label>
                                            <input type="text" class="form-control" id="manager_position" name="manager_position">
                                            <small class="form-text text-muted">e.g., PA, Manager, Admin, etc.</small>
                                        </div>

                                    </div>

                                    <div class="row d-none" id="company_information">
                                        <!-- Manager Information Form Fields -->
                                        <div class="col-12 card-header py-3 mb-3">
                                            <h6 class="font-weight-bold text-primary">Company Details</h6>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="company_name" class="form-label">Company Name  <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" name="company_name" id="company_name" class="form-control" value="{{old('company_name')}}">
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="company_mobile" class="form-label">Company Mobile</label>
                                            <input type="number" name="company_mobile" id="company_mobile" class="form-control" min="0" value="{{old('company_mobile')}}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="company_gst" class="form-label">GST Number</label>
                                            <input type="text" name="company_gst" id="company_gst" class="form-control" value="{{old('company_gst')}}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="company_address" class="form-label">Address</label>
                                            <textarea name="company_address" id="company_address" class="form-control">{{old('company_address')}}</textarea>
                                        </div>

                                    </div>
                            </div>


                            <div class="card-footer">
                                <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button></div>
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


    <script>

        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            field.classList.add('is-invalid');
            const errorMessage = document.createElement('div');
            errorMessage.className = 'invalid-feedback';
            errorMessage.textContent = message;
            field.parentNode.appendChild(errorMessage);
        }

        function clearErrors() {
            const invalidFields = document.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
                const feedback = field.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            });
        }

        document.getElementById('have_manager').addEventListener('change', function() {
            var managerInfoDiv = document.getElementById('manager_information');

            var managerFields = managerInfoDiv.querySelectorAll('input');

            if (this.checked) {
                managerInfoDiv.classList.remove('d-none');
                managerFields.forEach(function(input) {
                    input.setAttribute('required', 'required');
                });
            } else {
                managerInfoDiv.classList.add('d-none');
                managerFields.forEach(function(input) {
                    input.removeAttribute('required');
                    input.value = '';
                });
            }
        });


        document.getElementById('have_company').addEventListener('change', function() {
            var companyInfoDiv = document.getElementById('company_information');

            var companyFields = companyInfoDiv.querySelectorAll('input');

            if (this.checked) {
                companyInfoDiv.classList.remove('d-none');
                companyFields.forEach(function(input) {
                    input.setAttribute('required', 'required');
                });
            } else {
                companyInfoDiv.classList.add('d-none');
                companyFields.forEach(function(input) {
                    input.removeAttribute('required');
                    input.value = '';
                });
            }
        });


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


        document.getElementById("customerForm").addEventListener("submit", function(e) {
            let isValid = true;
            const email = document.getElementById('email').value.trim();
            const pincode = document.getElementById('pincode').value.trim();
            const country_id = document.getElementById('country_id').value;
            const state_id = document.getElementById('state_id').value;
            const city_id = document.getElementById('city_id').value;
            const mobilePattern = /^\d{10}$/;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            clearErrors();

            if (!fname) {
                showError('fname', 'First Name is required.');
                isValid = false;
            }
            if (!lname) {
                showError('lname', 'Last Name is required.');
                isValid = false;
            }

            if (email && !emailPattern.test(email)) {
                showError('email', 'Please enter a valid email address.');
                isValid = false;
            }
            if (country_id && !state_id) {
                showError('state_id', 'State is required.');
                isValid = false;
            }
            if (country_id && state_id && !city_id) {
                showError('city_id', 'City is required.');
                isValid = false;
            }

            // Validate and set full international mobile number
            if (phoneInput.isValidNumber()) {
                const fullMobileNumber = phoneInput.getNumber();
                console.log("Full Mobile Number:", fullMobileNumber);
                phoneInputField.value = fullMobileNumber;
            } else {
                isValid = false;
                showError('mobile', 'Please enter a valid mobile number.');
            }

            if (whatsappInput.isValidNumber()) {
                const fullWhatsAppNumber = whatsappInput.getNumber();
                console.log("Full WhatsApp Number:", fullWhatsAppNumber);
                whatsappInputField.value = fullWhatsAppNumber;
            } else {
                isValid = false;
                showError('whatsapp', 'Please enter a valid WhatsApp number.');
            }

            const haveManagerChecked = document.getElementById('have_manager').checked;
            // Validate manager fields if 'have_manager' checkbox is checked
            if (haveManagerChecked) {
                const manager_fname = document.getElementById('manager_fname').value.trim();
                const manager_lname = document.getElementById('manager_lname').value.trim();
                const manager_mobile = document.getElementById('manager_mobile').value.trim();
                const manager_whatsapp = document.getElementById('manager_whatsapp').value.trim();
                const manager_email = document.getElementById('manager_email').value.trim();

                if (!manager_fname) {
                    showError('manager_fname', 'Manager First Name is required.');
                    isValid = false;
                }

                if (!manager_lname) {
                    showError('manager_lname', 'Manager Last Name is required.');
                    isValid = false;
                }

                if (manager_phoneInput.isValidNumber()) {
                    const mfullMobileNumber = manager_phoneInput.getNumber();
                    console.log("Mgr Full Mobile Number:", mfullMobileNumber);
                    manager_phoneInputField.value = mfullMobileNumber;
                } else {
                    isValid = false;
                    showError('manager_mobile', 'Please enter a valid mobile number.');
                }

                if (manager_whatsappInput.isValidNumber()) {
                    const mfullWhatsAppNumber = manager_whatsappInput.getNumber();
                    console.log("Mgr Full WhatsApp Number:", mfullWhatsAppNumber);
                    manager_whatsappInputField.value = mfullWhatsAppNumber;
                } else {
                    isValid = false;
                    showError('manager_whatsapp', 'Please enter a valid WhatsApp number.');
                }

                if (manager_email && !emailPattern.test(manager_email)) {
                    showError('manager_email', 'Please enter a valid Manager Email address.');
                    isValid = false;
                }

            }

            const haveCompanyChecked = document.getElementById('have_company').checked;
            if (haveCompanyChecked) {

                const company_name = document.getElementById('company_name').value.trim();
                const company_mobile = document.getElementById('company_mobile').value.trim();
                const company_gst = document.getElementById('company_gst').value.trim();
                const company_address = document.getElementById('company_address').value.trim();

                if (!company_name) {
                    showError('company_name', 'Company Name is required.');
                    isValid = false;
                }

                if (company_mobile && !mobilePattern.test(company_mobile)) {
                    showError('company_mobile', 'Company Mobile number must be 10 digits.');
                    isValid = false;
                }

                // if (!company_gst) {
                //     showError('company_gst', 'Please enter a valid GST number.');
                //     isValid = false;
                // }

                // if (!company_address) {
                //     showError('company_address', 'Please enter the address.');
                //     isValid = false;
                // }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var countrySelect = document.getElementById('country_id');
        var stateSelect = document.getElementById('state_id');
        var citySelect = document.getElementById('city_id');

        countrySelect.addEventListener('change', function() {
            var countryId = this.value;

            // Clear current state and city options
            stateSelect.innerHTML = '<option value="">Select State</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (countryId) {
                // Fetch states based on the selected country
                fetch('/get-states/' + countryId)
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
                        console.error('There was a problem with fetch operation:', error);
                    });
            }
        });

        stateSelect.addEventListener('change', function() {
            var stateId = this.value;

            // Clear current city options
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (stateId) {
                // Fetch cities based on the selected state
                fetch('/get-cities/' + stateId)
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        // Populate city dropdown with fetched cities
                        data.forEach(function(city) {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(function(error) {
                        console.error('There was a problem with fetch operation:', error);
                    });
            }
        });
    });
</script>

@endsection
