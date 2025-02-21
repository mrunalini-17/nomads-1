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
                        <h3 class="font-weight-bold text-primary">View Enquiry</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary"> Back </a>
                    </div>

                    <!-- Booking Details -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0">ID : {{ $enquiry->unique_code }} </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
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
                                        <td> {{ ucfirst($enquiry->status) }}</td>
                                        <td><strong>Notes:</strong></td>
                                        <td> {{ $enquiry->note }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Assigned To</strong></td>
                                        <td>
                                            @if($employees->isNotEmpty())
                                                {{ $employees->map(function($employee) {
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
                        @if(!$enquiry->is_accepted)
                        <div class="card-footer d-flex justify-content-center">
                            <input type="hidden" name="update" value="0">
                            <button type="button" id="accept_button" class="btn btn-success accepted" data-enquiry-id="{{$enquiry->id}}">Accept</button>
                        </div>
                        @else
                        <div class="card-footer d-flex justify-content-center">
                            <input type="hidden" name="update" value="1">
                            <button type="button" id="update_button" class="btn btn-primary update" data-enquiry-id="{{$enquiry->id}}">Update</button>
                        </div>
                        @endif
                    </form>
                    </div>

<!-- Follow-ups -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="m-0">Follow-ups</h5>
        <button class="btn btn-link text-white toggle-collapse" data-bs-toggle="collapse" data-bs-target="#followupsCollapse" aria-expanded="true" aria-controls="followupsCollapse">
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div id="followupsCollapse" class="collapse">
        <div class="card-body">
            <form action="{{ route('followups.store') }}" method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" id="enquiry_id" name="enquiry_id" value="{{$enquiry->unique_code}}" required>

                    <div class="form-group col-md-6">
                        <label for="followup_date" class="form-label">Follow-up Date</label>
                        <input type="date" class="form-control" id="fdate" name="fdate" value="{{old('fdate')}}" required>
                        @error('fdate')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="followup_time" class="form-label">Follow-up Time</label>
                        <input type="time" class="form-control" id="ftime" name="ftime" value="{{old('ftime')}}" required>
                        @error('ftime')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remark" name="remark" rows="3">{{old('remark')}}</textarea>
                        @error('remark')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="followup_type" class="form-label">Follow-up Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="Routine Follow-up" {{ old('type') === "Routine Follow-up" ? 'selected' : '' }}>Routine Follow-up</option>
                            <option value="Schedule Meeting" {{ old('type') === "Schedule Meeting" ? 'selected' : '' }}>Schedule Meeting</option>
                        </select>
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
        </div>
        <div class="card-footer mt-4 text-center">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
    </div>
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
        //accept the enquiry
        document.getElementById('accept_button').addEventListener('click', function(e) {
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
                // If validation passes, submit the form
                document.getElementById('add_remarks_form').submit();
            }
        });

    </script>

<script>
    //accept the enquiry
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
            // If validation passes, submit the form
            document.getElementById('add_remarks_form').submit();
        }
    });

</script>

<script>
    document.querySelector('.toggle-collapse').addEventListener('click', function () {
        const icon = this.querySelector('i');
        const isCollapsed = this.getAttribute('aria-expanded') === 'true';

        if (isCollapsed) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });
</script>


@endsection
