@extends('layout.app')
@section('title', 'Dashboard')

<style>
    .table_view {
        table-layout: fixed;
        width: 100%;
    }

    .table_view th,
    .table_view td {
        width: 25%;
        word-wrap: break-word;
    }


    .badge {
        display: inline-block;
        margin: 2px;
    }
</style>
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
                        <h3 class="font-weight-bold text-primary">Update Enquiry</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ route("accepted_enquiries.index") }}" class="btn btn-sm btn-primary"> Back </a>
                    </div>

                    <!-- Booking Details -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0">Enquiry Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table_view">
                                <tbody>
                                    <tr>
                                        <td><strong>Customer</strong> </td>
                                        <td> {{ $enquiry->fname ?? 'N/A' }} {{ $enquiry->lname ?? '' }}</td>

                                        <td><strong>Date</strong></td>
                                        <td> {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mobile</strong></td>
                                        <td> {{ $enquiry->mobile ?? '--' }}</td>

                                        <td><strong>Whatsapp</strong></td>
                                        <td> {{ $enquiry->whatsapp ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td> {{ $enquiry->email ?? '--' }}</td>
                                        <td><strong>Address</strong></td>
                                        <td> {{ $enquiry->address ?? '--' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Priority</strong></td>
                                        <td> {{ ucfirst($enquiry->priority) }}</td>
                                        <td><strong>Service</strong></td>
                                        <td>
                                            @foreach ($enquiry->services as $service)
                                            {{ $service->name }}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        {{-- <td> {{ ucfirst($enquiry->status) }}</td> --}}
                                        <td id="change_status" class="">
                                            <select class="form-control" id="status" name="status">
                                                <option value="Active" {{ $enquiry->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Converted" {{ $enquiry->status == 'Converted' ? 'selected' : '' }}>Converted</option>
                                                <option value="Dead" {{ $enquiry->status == 'Dead' ? 'selected' : '' }}>Dead</option>
                                            </select>
                                        </td>
                                        <td><strong>Notes:</strong></td>
                                        <td> {{ $enquiry->note }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Assigned To</strong></td>
                                        <td>
                                            @if($assignedemployees->isNotEmpty())
                                                {{ $assignedemployees->map(function($employee) {
                                                    return $employee->first_name . ' ' . $employee->last_name;
                                                })->join(', ') }}
                                            @else
                                                Not assigned
                                            @endif
                                        </td>
                                        <td><strong>Accepted By</strong></td>
                                        <td class="text-primary"> {{ optional($enquiry->acceptedBy)->first_name . ' ' . optional($enquiry->acceptedBy)->last_name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0">Remarks</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
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
                                        <tr class="{{ $remark->remark_type === "transfer" ? 'table-warning' : '' }}">
                                            <td>{{ ucfirst($remark->remark_type) }}</td>
                                            <td>{{ $remark->description ?? 'N/A' }}</td>
                                            <td>{{ $remark->created_at->format('d/m/Y') }}</td>
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
                        </div>
                    </div>

                    <!-- Add Remarks -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0">Add Remarks</h5>
                        </div>
                        <form action="{{ route('new_enquiry.accept', $enquiry->id) }}" id="add_remarks_form" method="POST">
                            <div class="card-body">

                                    @csrf
                                    <div class="row">
                                        <div id="remarksContainer" class="col-12 col-md-12">
                                            <div class="remark-group row col-12 col-md-12" id="remark_group_1">
                                                <div class="mb-3 col col-3">
                                                    <label for="remark_type_1" class="form-label">Remark Type <span class="text-danger">*</span></label>
                                                    <select name="remark_type[]" id="remark_type_1" class="form-select form-control" required>
                                                        <option value="" disabled>Select</option>
                                                        <option value="office">Office</option>
                                                        <option value="client">Client</option>
                                                    </select>
                                                    @error('remark_type.0')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 col col-8">
                                                    <label for="remark_1" class="form-label">Remark <span class="text-danger">*</span></label>
                                                    <textarea name="remark[]" id="remark_1" cols="" rows="" class="form-control"></textarea>
                                                    @error('remark.0')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-1 text-right mt-4">
                                                    <button type="button" class="btn btn-danger btn-sm btn-remove" data-id="1"><i class="fas fa-trash"></i></button>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" id="addRemarkBtn" class="btn btn-sm btn-success">Add More Remark</button>
                                    </div>

                            </div>

                            <div class="card-footer d-flex justify-content-center">
                                <input type="hidden" name="update" value="1">
                                <button type="button" id="update_button" class="btn btn-primary update" data-enquiry-id="{{$enquiry->id}}">Update</button>
                            </div>
                        </form>
                    </div>

                    <!-- Follow-ups  -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0">Follow-ups</h5>
                        </div>

                    </div>



                    <!-- Transfer enquiry-->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="m-0">Transfer Enquiry</h5>
                        </div>
                        <form action="{{ route('transfer_enquiry', $enquiry->id) }}" id="transfer_enquiry" method="POST">
                            {{-- <form action="" id="transfer_enquiry" method="POST"> --}}
                            <div class="card-body">
                                <p>Do you wish to transfer this enquiry to another user? Add a remark stating reason.</p>

                                    @csrf
                                    <div class="row">
                                        {{-- <div class="mb-3 col col-3">
                                            <label for="employee" class="form-label">Assign To <span class="text-danger">*</span></label>
                                            <select name="employee" id="employee" class="form-select form-control" required>
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('employee')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}


                                                <input type="hidden" name="remark_type_tranfer" value="office">
                                                <div class="mb-3 col col-12">
                                                    <label for="remark_transfer" class="form-label">Remark <span class="text-danger">*</span></label>
                                                    <textarea name="remark_transfer" id="remark_transfer" cols="" rows="" class="form-control"></textarea>
                                                    @error('remark_transfer')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                        </div>




                            </div>

                            <div class="card-footer d-flex justify-content-center">
                                <input type="hidden" name="transfer" value="1">
                                <button type="button" id="transfer_button" class="btn btn-secondary transfer" data-enquiry-id="{{$enquiry->id}}">Transfer</button>
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
    // Add More Remarks functionality
    let remarkCount = 1;

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
                    <option value="client">Client</option>
                    <option value="office">Office</option>
                </select>
            </div>
            <div class="mb-3 col col-8">
                <label for="remark_${remarkCount}" class="form-label">Remark</label>
                <textarea name="remark[]" id="remark_${remarkCount}" cols="" rows="" class="form-control"></textarea>
            </div>
            <div class="col-1 text-right mt-4">
                <button type="button" class="btn btn-danger btn-sm btn-remove" data-id="${remarkCount}"><i class="fas fa-trash"></i></button>
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
        });
    });
</script>



<script>
    document.getElementById('update_button').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form submission

        let isValid = true;

        // Loop through all the remark groups to validate inputs
        document.querySelectorAll('.remark-group').forEach(function(group) {
            const remarkType = group.querySelector('select[name="remark_type[]"]');
            const remark = group.querySelector('textarea[name="remark[]"]');

            // Clear previous error messages
            remarkType.classList.remove('is-invalid');
            remark.classList.remove('is-invalid');
            group.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

            // Validate Remark Type
            if (!remarkType.value) {
                isValid = false;
                remarkType.classList.add('is-invalid');
                const error = document.createElement('div');
                error.className = 'invalid-feedback';
                error.innerText = 'Please select a remark type.';
                remarkType.parentNode.appendChild(error);
            }

            // Validate Remark Description
            if (!remark.value.trim()) {
                isValid = false;
                remark.classList.add('is-invalid');
                const error = document.createElement('div');
                error.className = 'invalid-feedback';
                error.innerText = 'Please enter a remark.';
                remark.parentNode.appendChild(error);
            }
        });

        if (isValid) {
            let statusValue = document.getElementById('status').value;

            // Create a hidden input field
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'status';
            hiddenInput.value = statusValue;

            // Append the hidden input field to the form
            let form = document.getElementById('add_remarks_form');
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    });

    $(document).ready(function() {
        // Apply Select2 on the services and edit services dropdown
        $('#employee').select2({
            placeholder: 'Select',
            allowClear: true,
            width: '100%'
        });

        document.getElementById('transfer_button').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission

            let isValid = true;

                // const employee = document.querySelector('select[name="employee"]');
                const remark = document.querySelector('textarea[name="remark_transfer"]');

                // Clear previous error messages
                // employee.classList.remove('is-invalid');
                remark.classList.remove('is-invalid');
                document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                // Validate Remark Type
                // if (!employee.value) {
                //     isValid = false;
                //     employee.classList.add('is-invalid');
                //     const error = document.createElement('div');
                //     error.className = 'invalid-feedback';
                //     error.innerText = 'Please select an option.';
                //     employee.parentNode.appendChild(error);
                // }

                // Validate Remark Description
                if (!remark.value.trim()) {
                    isValid = false;
                    remark.classList.add('is-invalid');
                    const error = document.createElement('div');
                    error.className = 'invalid-feedback';
                    error.innerText = 'Please enter a remark.';
                    remark.parentNode.appendChild(error);
                }


            if (isValid) {
                // If validation passes, submit the form
                document.getElementById('transfer_enquiry').submit();
            }
        });
    });

</script>

@endsection
