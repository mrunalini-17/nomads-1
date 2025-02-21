@extends('layout.app')
@section('title', 'Edit Customer')
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
                        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary">Back</a>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Customer</h6>
                        </div>
                        <form action="{{ route('customers.update', $customer->id) }}" method="POST" id="customerForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col col-6">
                                            <label for="fname" class="form-label">First Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="fname" name="fname" value="{{ old('fname', $customer->fname) }}" required>
                                            @error('fname')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col col-6">
                                            <label for="lname" class="form-label">Last Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="lname" name="lname" value="{{ old('lname', $customer->lname) }}" required>
                                            @error('lname')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>




                                        <div class="mb-3 col col-6">
                                            <label for="mobile" class="form-label">Mobile<span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="mobile" name="mobile" min="0" value="{{ old('mobile', $customer->mobile) }}" required oninput="document.getElementById('whatsapp').value = this.value;">
                                            @error('mobile')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col col-6">
                                            <label for="whatsapp" class="form-label">WhatsApp</label>
                                            <input type="tel" class="form-control" id="whatsapp" name="whatsapp" min="0" value="{{ old('whatsapp', $customer->whatsapp) }}">
                                            @error('whatsapp')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col col-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer->email) }}">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                                <option value="" disabled>Select Gender</option>
                                                <option value="Male" {{ old('gender', $customer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $customer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender', $customer->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col col-6">
                                            <label for="address" class="form-label">Locality <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="locality" name="locality" rows="1">{{ old('locality', $customer->locality) }}</textarea>
                                            @error('locality')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col col-6">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="number" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', $customer->pincode) }}">
                                            @error('pincode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>



                                        <div class="mb-3 col col-6">
                                            <div class="form-group">
                                                <label for="country_id">Country </label>
                                                <select class="form-control @error('country_id') is-invalid @enderror"
                                                    id="country_id" name="country_id">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                            {{ old('country_id',$customer->country_id) == $country->id ? 'selected' : '' }}>
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
                                                    <label for="state_id">State </label>
                                                    <select class="form-control @error('state_id') is-invalid @enderror"
                                                        id="state_id" name="state_id">
                                                        <option value="">Select State</option>
                                                        {{-- @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ old('state_id',$customer->state_id) == $state->id ? 'selected' : '' }}>
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
                                                    <label for="city_id">City</label>
                                                    <select class="form-control @error('city_id') is-invalid @enderror"
                                                        id="city_id" name="city_id">
                                                        <option value="">Select City</option>
                                                        {{-- @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                {{ old('city_id',$customer->city_id) == $city->id ? 'selected' : '' }}>
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
                                                                {{ old('reference_id',$customer->reference_id) == $reference->id ? 'selected' : '' }}>
                                                                {{ $reference->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('reference_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- @if($customer->managers->isNotEmpty())
                                            <div class="mb-3 col col-6 ml-3">
                                                <div class="form-check">
                                                    <input type="hidden" name="have_manager" value="0">
                                                    <input type="checkbox" class="form-check-input border-3 border-info" id="have_manager"
                                                           name="have_manager" value="1" {{ old('have_manager', $customer->have_manager) == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="have_manager" class="mr-3">Has Manager</label>
                                                </div>
                                            </div>
                                            @else
                                            <div class="mb-3 col-md-6 ml-3">
                                                <div class="form-check">
                                                <input type="hidden" name="have_manager" value="0">
                                                <input type="checkbox" class="form-check-input border-3 border-info" id="have_manager"
                                                    name="have_manager" value="1">
                                                <label class="form-check-label" for="have_manager" class="mr-3"> Has Manager</label></div>
                                            </div>
                                            @endif --}}
                                    </div>

                                    <div class="row d-none" id="manager_information">
                                        <!-- Manager Information Form Fields -->
                                        <div class="col-12 card-header py-3 mb-3 d-flex justify-content-between align-items-center">
                                            <h6 class="font-weight-bold text-primary mb-0">Manager Details</h6>
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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
                                            <input type="tel" class="form-control" id="manager_mobile" name="manager_mobile"min="0">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_whatsapp" class="form-label">WhatsApp</label>
                                            <input type="tel" class="form-control" id="manager_whatsapp" name="manager_whatsapp" min="0">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="manager_email" name="manager_email">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="manager_position" class="form-label">Relation</label>
                                            <input type="text" class="form-control" id="manager_position" name="manager_position">
                                            <small class="form-text text-muted">e.g., PA, Manager, Admin, etc.</small>
                                        </div>

                                    </div>
                            </div>


                            <div class="card-footer">
                                <div class="text-center"> <button type="submit" class="btn btn-success">Submit</button></div>
                            </div>
                        </form>
                    </div>

                                                        <!-- Manager Details -->
                                                        @if($customer->managers->isNotEmpty())
                                                            <div class="card mb-4">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">Manager Information</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table table-striped">
                                                                        @foreach($customer->managers as $manager)
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <td>{{ $manager->fname ?? 'NA' }} {{ $manager->lname ?? 'NA' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Mobile</th>
                                                                                <td>{{ $manager->mobile ?? 'NA' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>WhatsApp</th>
                                                                                <td>{{ $manager->whatsapp ?? 'NA' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Email</th>
                                                                                <td>{{ $manager->email ?? 'NA' }}</td>
                                                                            </tr>
                                                                            {{-- <tr>
                                                                                <th>Position</th>
                                                                                <td>{{ $manager->relation ?? 'NA' }}</td>
                                                                            </tr> --}}
                                                                            <tr>
                                                                                <td colspan="2">
                                                                                    <div class="text-end">
                                                                                        <!-- Button to edit the manager -->
                                                                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editManagerModal{{ $manager->id }}">
                                                                                            Edit Manager
                                                                                        </button>
                                                                                        <!-- Form to delete the manager -->
                                                                                        <form action="{{ route('customer-managers.destroy', ['customerId' => $customer->id, 'managerId' => $manager->id]) }}" method="POST" style="display:inline;">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this manager?');">
                                                                                                Delete Manager
                                                                                            </button>
                                                                                        </form>

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="card mb-4" id="no_manager">
                                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                                    <h5 class="card-title mb-0">No Manager Assigned</h5>
                                                                    <button class="btn btn-success" id="add_manager">Add Manager</button>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p>No managers have been assigned to this customer.</p>
                                                                </div>

                                                            </div>
                                                        @endif

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
        <!-- Edit manager Modal -->
        @foreach($customer->managers as $manager)

            <div class="modal fade" id="editManagerModal{{ $manager->id }}" tabindex="-1" aria-labelledby="editManagerModalLabel{{ $manager->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editManagerModalLabel{{ $manager->id }}">Manager Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('customer-managers.update', $manager->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Manager Information Form Fields -->
                                    <div class="mb-3 col col-6">
                                        <label for="fname{{ $manager->id }}" class="form-label">First Name <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="text" class="form-control" id="fname{{ $manager->id }}" name="manager_fname" value="{{ $manager->fname }}" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="lname{{ $manager->id }}" class="form-label">Last Name <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="text" class="form-control" id="lname{{ $manager->id }}" name="manager_lname" value="{{ $manager->lname }}" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="manager_mobile{{ $manager->id }}" class="form-label">Mobile <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="tel" class="form-control" id="manager_mobile{{ $manager->id }}" name="manager_mobile" value="{{ $manager->mobile }}" required>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="manager_whatsapp{{ $manager->id }}" class="form-label">WhatsApp <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="tel" class="form-control" id="manager_whatsapp{{ $manager->id }}" name="manager_whatsapp" value="{{ $manager->whatsapp }}">
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="manager_email{{ $manager->id }}" class="form-label">Email <span class="text-danger"><sup>*</sup></span></label>
                                        <input type="email" class="form-control" id="manager_email{{ $manager->id }}" name="manager_email" value="{{ $manager->email }}">
                                    </div>
                                    {{-- <div class="mb-3 col col-6">
                                        <label for="manager_position{{ $manager->id }}" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="manager_position{{ $manager->id }}" name="manager_position" value="{{ $manager->relation }}">
                                        <small class="form-text text-muted">e.g., PA, Manager, Admin, etc.</small>
                                    </div> --}}
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



    <script>


        document.getElementById('add_manager').addEventListener('click', function() {
            var managerInfoDiv = document.getElementById('manager_information');
            var managerFields = managerInfoDiv.querySelectorAll('input');
            const nomanagerdiv = document.getElementById('no_manager');

            managerInfoDiv.classList.remove('d-none');
            managerFields.forEach(function(input) {
                input.setAttribute('required', 'required');
            });

            nomanagerdiv.style.display = 'none';
        });


        document.querySelector('#manager_information .close').addEventListener('click', function() {
            var managerInfoDiv = document.getElementById('manager_information');
            var managerFields = managerInfoDiv.querySelectorAll('input');
            const nomanagerdiv = document.getElementById('no_manager');

            managerInfoDiv.classList.add('d-none');
            managerFields.forEach(function(input) {
                input.removeAttribute('required');
                input.value = '';
            });

            nomanagerdiv.style.display = 'block';
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var countrySelect = document.getElementById('country_id');
        var stateSelect = document.getElementById('state_id');
        var citySelect = document.getElementById('city_id');

        var customerCountryId = '{{ old("country_id", $customer->country_id) }}';
        var customerStateId = '{{ old("state_id", $customer->state_id) }}';
        var customerCityId = '{{ old("city_id", $customer->city_id) }}';

        // Function to fetch and populate states based on the selected country
        function fetchStates(countryId, callback) {
            fetch('/get-states/' + countryId)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    // Populate state dropdown with fetched states
                    stateSelect.innerHTML = '<option value="" selected disabled>Select State</option>';
                    data.forEach(function(state) {
                        var option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name;
                        stateSelect.appendChild(option);
                    });

                    // If there's a customer state, select it
                    if (customerStateId) {
                        stateSelect.value = customerStateId;
                        fetchCities(customerStateId); // Fetch cities for the selected state
                    }

                    if (callback) callback();
                })
                .catch(function(error) {
                    console.error('There was a problem with fetch operation:', error);
                });
        }

        // Function to fetch and populate cities based on the selected state
        function fetchCities(stateId) {
            fetch('/get-cities/' + stateId)
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function(data) {
                    // Populate city dropdown with fetched cities
                    citySelect.innerHTML = '<option value="" selected disabled>Select City</option>';
                    data.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });

                    // If there's a customer city, select it
                    if (customerCityId) {
                        citySelect.value = customerCityId;
                    }
                })
                .catch(function(error) {
                    console.error('There was a problem with fetch operation:', error);
                });
        }

        // Listen for changes to the country dropdown
        countrySelect.addEventListener('change', function() {
            var countryId = this.value;

            // Clear current state and city options
            stateSelect.innerHTML = '<option value="" selected disabled>Select State</option>';
            citySelect.innerHTML = '<option value="" selected disabled>Select City</option>';

            if (countryId) {
                fetchStates(countryId);
            }
        });

        // Listen for changes to the state dropdown
        stateSelect.addEventListener('change', function() {
            var stateId = this.value;

            // Clear current city options
            citySelect.innerHTML = '<option value="" selected disabled>Select City</option>';

            if (stateId) {
                fetchCities(stateId);
            }
        });

        // If a country is selected on page load, trigger the state fetching
        if (countrySelect.value) {
            fetchStates(countrySelect.value);
        }
    });
</script>


<script>
    const mobileInputField = document.querySelector("#mobile");
    const whatsappInputField = document.querySelector("#whatsapp");

    const mobileInput = window.intlTelInput(mobileInputField, {
        separateDialCode: true,
        preferredCountries: ["in", "us", "uk"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    const whatsappInput = window.intlTelInput(whatsappInputField, {
        separateDialCode: true,
        preferredCountries: ["in", "us", "uk"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    // Copy mobile number to WhatsApp field if it’s empty
    mobileInputField.addEventListener("input", () => {
        if (!whatsappInputField.value) {
            whatsappInput.setNumber(mobileInput.getNumber());
        }
    });

    document.getElementById("customerForm").addEventListener("submit", function(e) {
        if (mobileInput.isValidNumber()) {
            mobileInputField.value = mobileInput.getNumber();
        } else {
            e.preventDefault();
            alert("Please enter a valid mobile number.");
        }

        if (whatsappInputField.value && whatsappInput.isValidNumber()) {
            whatsappInputField.value = whatsappInput.getNumber();
        } else if (whatsappInputField.value) {
            e.preventDefault();
            alert("Please enter a valid WhatsApp number.");
        }
    });
</script>


@endsection
