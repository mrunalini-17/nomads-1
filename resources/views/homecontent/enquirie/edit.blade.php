@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
    <!-- Page Wrapper -->

    <style>
        .dashed-line {
            border-top: 2px dashed #ccc;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
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
                        <h3 class="font-weight-bold text-primary">Edit Enquiry</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Enquiry ID: {{ $enquiry->unique_code }}</h6>
                        </div>
                        <form action="{{ route('enquiries.update', $enquiry->id) }}" id="edit_enquiry_form" method="POST">
                        <div class="card-body">

                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="mb-3 col col-6">
                                        <label for="name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="fname" name="fname" value="{{ old('fname', $enquiry->fname) }}" readonly>
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lname" name="lname" value="{{ old('lname', $enquiry->lname) }}" readonly>
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="mobile" name="mobile" min="0" value="{{ old('mobile', $enquiry->mobile) }}" required oninput="document.getElementById('whatsapp').value = this.value;">
                                        <small id="mobile-error" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="whatsapp" class="form-label">WhatsApp</label>
                                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp"  min="0" value="{{ old('whatsapp', $enquiry->whatsapp) }}">
                                        <small id="whatsapp-error" class="text-danger"></small>
                                    </div>

                                    <div class="mb-3 col col-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $enquiry->email) }}">
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $enquiry->address) }}">
                                    </div>
                                    @if ($enquiry->is_accepted == 1 && $enquiry->acceptedBy)
                                    <div class="mb-3 col col-6">
                                        <label for="accepted_by" class="form-label">Accepted By</label>
                                        <input type="text" class="form-control" id="accepted_by"
                                               value="{{ optional($enquiry->acceptedBy)->first_name . ' ' . optional($enquiry->acceptedBy)->last_name }}" readonly>

                                    </div>
                                    @else
                                    <div class="mb-3 col col-6">
                                        <label for="employee_id" class="form-label">Assign To</label>
                                        <select class="form-control" id="employees" name="employees[]" multiple="multiple">
                                            <option value="">Select employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                        {{ in_array($employee->id, $enquiry->employees->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @endif

                                    <div class="mb-3 col col-6">
                                        <label for="service_id" class="form-label">Service <span class="text-danger">*</span></label>
                                        <select class="form-control" id="services" name="services[]" multiple="multiple" required>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}"
                                                        {{ in_array($service->id, $enquiry->services->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="status" class="form-label">Priority </label>
                                        <input type="text" class="form-control" value="{{ $enquiry->priority }}" readonly>
                                        {{-- <select class="form-control" id="priority" name="priority" required>
                                            <option value="Corporate" {{ $enquiry->priority == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                                            <option value="Urgent" {{ $enquiry->priority == 'Urgent' ? 'selected' : '' }}>Urgent(travel within 48Hrs)</option>
                                            <option value="High" {{ $enquiry->priority == 'High' ? 'selected' : '' }}>High</option>
                                            <option value="Medium" {{ $enquiry->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="Low" {{ $enquiry->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                        </select> --}}
                                    </div>
                                    <div class="mb-3 col col-6">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span> </label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="New" {{ $enquiry->status == 'New' ? 'selected' : '' }}>New</option>
                                            <option value="Active" {{ $enquiry->status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Converted" {{ $enquiry->status == 'Converted' ? 'selected' : '' }}>Converted</option>
                                            <option value="Dead" {{ $enquiry->status == 'Dead' ? 'selected' : '' }}>Dead</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-12 col-md-12">
                                        <label for="note" class="form-label">Notes</label>
                                        <textarea name="note" id="note" cols="" rows="" class="form-control" readonly>{{ $enquiry->note,old('note') }}</textarea>
                                    </div>
                                    <table class="table table-bordered table-striped m-4">
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
                                        <tbody>
                                            @forelse ($enquiry->enquiryRemarks as $remark)
                                                <tr>
                                                    <td>{{ ucfirst($remark->remark_type) }}</td>
                                                    <td>{{ $remark->description ?? 'N/A' }}</td>
                                                    <td>{{ $remark->created_at->format('d/m/Y') }}</td> <!-- Format Date -->
                                                    <td>{{ $remark->created_at->format('H:i') }}</td>
                                                    <td>{{ $remark->email_sent ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $remark->addedBy->first_name ?? 'N/A' }} {{ $remark->addedBy->last_name ?? 'N/A' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-muted text-center">No remarks available.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>

                                    <div class="dashed-line" style="border-top: 2px dashed #ccc;  margin-top: 20px;  margin-bottom: 20px;"></div>

                                    <div id="remarksContainer" class="col-12 col-md-12">

                                    </div>

                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="button" id="addRemarkBtn" class="btn btn-sm btn-success">Add More Remark</button>
                                </div>


                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Update Enquiry</button>
                                <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            @include('shared.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script>
    document.getElementById('edit_enquiry_form').addEventListener('submit', function(event) {
        // Clear previous error messages
        document.getElementById('mobile-error').textContent = '';
        document.getElementById('whatsapp-error').textContent = '';

        const mobile = document.getElementById('mobile');
        const whatsapp = document.getElementById('whatsapp');
        const mobileRegex = /^\d{10}$/;

        let isValid = true;

        // Validate mobile number
        if (!mobileRegex.test(mobile.value)) {
            document.getElementById('mobile-error').textContent = 'Mobile number must be 10 digits.';
            isValid = false;
        }

        // Validate WhatsApp number (if provided)
        if (whatsapp.value && !mobileRegex.test(whatsapp.value)) {
            document.getElementById('whatsapp-error').textContent = 'WhatsApp number must be 10 digits.';
            isValid = false;
        }

        // Validate each remark group
        const remarkGroups = document.querySelectorAll('.remark-group');
        remarkGroups.forEach((group, index) => {
            const remarkType = group.querySelector(`#remark_type_${index + 1}`);
            const remark = group.querySelector(`#remark_${index + 1}`);
            const remarkTypeError = document.getElementById(`remark_type_error_${index + 1}`);
            const remarkError = document.getElementById(`remark_error_${index + 1}`);

            // Clear previous remark errors
            remarkTypeError.textContent = '';
            remarkError.textContent = '';

            // Validate remark type
            if (!remarkType.value) {
                remarkTypeError.textContent = 'Remark type is required.';
                isValid = false;
            }

            // Validate remark content
            if (!remark.value.trim()) {
                remarkError.textContent = 'Remark cannot be empty.';
                isValid = false;
            }
        });


        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });



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
        });
    </script>


<script>
    // Add More Remarks functionality
    let remarkCount = 0;

    document.getElementById('addRemarkBtn').addEventListener('click', function() {
        remarkCount++;

        // Create a new Remark Group (Remark Type + Remark + Delete Button)
        const newRemarkGroup = document.createElement('div');
        newRemarkGroup.className = 'remark-group row col-12 col-md-12';
        newRemarkGroup.id = `remark_group_${remarkCount}`;

        newRemarkGroup.innerHTML = `
            <div class="mb-3 col col-3">
                <label for="remark_type_${remarkCount}" class="form-label">Remark Type</label>
                <select name="remark_type[]" id="remark_type_${remarkCount}" class="form-select form-control" required>
                    <option value="" disabled>Select</option>
                    <option value="office">Office</option>
                    <option value="client">Client</option>
                </select>
                <small id="remark_type_error_${remarkCount}" class="text-danger"></small>
            </div>
            <div class="mb-3 col col-8">
                <label for="remark_${remarkCount}" class="form-label">Remark</label>
                <textarea name="remark[]" id="remark_${remarkCount}" cols="" rows="" class="form-control"></textarea>
                <small id="remark_error_${remarkCount}" class="text-danger"></small>
            </div>
            <div class="col-1 text-right mt-4">
                <button type="button" class="btn btn-sm btn-danger btn-remove" data-id="${remarkCount}"><i class="fas fa-trash"></i></button>
            </div>
        `;

        // Append new remark group to the container
        document.getElementById('remarksContainer').appendChild(newRemarkGroup);

        // Attach the delete functionality to the newly added remove button
        document.querySelector(`#remark_group_${remarkCount} .btn-remove`).addEventListener('click', function() {
            const groupId = this.getAttribute('data-id');
            document.getElementById(`remark_group_${groupId}`).remove();
        });
    });

    // Attach delete functionality to any existing delete button if needed
    document.querySelectorAll('.btn-remove').forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.getAttribute('data-id');
            document.getElementById(`remark_group_${groupId}`).remove();
            remarkCount--;
        });
    });
    </script>

@endsection
