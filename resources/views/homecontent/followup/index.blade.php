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

                    {{-- Head --}}
                    <div class="py-3 px-2">
                        <h3 class="font-weight-bold text-primary">Followups List</h3>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="text-right mt-3"> <a href="{{ route('followups.create') }}"
                                class="btn btn-primary btn-sm mb-3 px-3 py-2">Add Follow-up</a>
                            </div>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="today-tab" data-bs-toggle="tab" href="#today"
                                        role="tab" aria-controls="today" aria-selected="true">Today's Follow-ups</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="upcoming-tab" data-bs-toggle="tab" href="#upcoming"
                                        role="tab" aria-controls="upcoming" aria-selected="false">Upcoming
                                        Follow-ups</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="missed-tab" data-bs-toggle="tab" href="#missed" role="tab"
                                        aria-controls="missed" aria-selected="false">Missed/Pending Follow-ups</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <!-- Today's Follow-ups Tab -->
                                <div class="tab-pane fade show active" id="today" role="tabpanel"
                                    aria-labelledby="today-tab">
                                    <table class="table table-bordered table-striped" id="dataTableToday" cellspacing="0">
                                           <thead class="bg-light text-dark">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Enquiry ID</th>
                                                <th>Follow-up Date</th>
                                                <th>Follow-up Time</th>
                                                <th>Follow-up Type</th>
                                                <th>Remark</th>
                                                <th>Updated By</th>
                                                <th>Note</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($followupsToday as $followup)
                                            <tr class="{{ $followup && $followup->status ? 'table-success' : '' }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="javascript:void(0);"
                                                       class="enquiry-details-link"
                                                       data-id="{{ $followup->enquiry_id }}"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#enquiryDetailsModal"
                                                       >
                                                        {{ $followup->enquiry_id }}
                                                    </a>
                                                </td>
                                                <td>{{ $followup->fdate->format('d-m-Y') }}</td>
                                                <td>{{ $followup->ftime }}</td>
                                                <td>{{ $followup->type }}</td>
                                                <td>{{ $followup->remark }}</td>
                                                <td>
                                                    @if ($followup->updatedBy)
                                                        {{ $followup->updatedBy->first_name ?? 'N/A' }} {{ $followup->updatedBy->last_name ?? 'N/A' }}
                                                    @else
                                                         N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($followup && $followup->status)
                                                        {{ $followup->note }}
                                                    @else
                                                            <textarea class="form-control form-control-sm"
                                                                        id="note_{{ $followup->id }}"
                                                                        name="note_{{ $followup->id }}"
                                                                        style="height: auto"
                                                                        {{ $followup && $followup->status ? 'disabled' : '' }}>
                                                            </textarea>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-sm btn-primary update-btn"
                                                                            id="update_{{ $followup->id }}"
                                                                            data-id="{{ $followup->id }}" {{ $followup->status ? 'disabled' : '' }}>
                                                                        <i class="fas fa-check"></i>
                                                                    </button>

                                                                    <form action="{{ route('followups.destroy', $followup->id) }}" method="POST" style="display:inline;">
                                                                      @csrf
                                                                      @method('DELETE')
                                                                      <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                                              onclick="return confirm('Are you sure you want to delete this follow-up?');">
                                                                              <i class="fas fa-trash"></i>
                                                                      </button>
                                                                </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Upcoming Follow-ups Tab -->
                                <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                    <table class="table table-bordered table-striped" id="dataTableUpcoming" cellspacing="0">
                                        <thead class="bg-light text-dark">
                                         <tr>
                                             <th>S.No</th>
                                             <th>Enquiry ID</th>
                                             <th>Follow-up Date</th>
                                             <th>Follow-up Time</th>
                                             <th>Follow-up Type</th>
                                             <th>Remark</th>
                                             <th>Updated By</th>
                                             <th>Note</th>
                                             <th>Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($followupsUpcoming as $followup)
                                         <tr class="{{ $followup && $followup->status ? 'table-success' : '' }}">
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $followup->enquiry_id}}</td>
                                             <td>{{ $followup->fdate->format('d-m-Y') }}</td>
                                             <td>{{ $followup->ftime }}</td>
                                             <td>{{ $followup->type }}</td>
                                             <td>{{ $followup->remark }}</td>
                                             <td>
                                                 @if ($followup->updatedBy)
                                                     {{ $followup->updatedBy->first_name ?? 'N/A' }} {{ $followup->updatedBy->last_name ?? 'N/A' }}
                                                 @else
                                                      N/A
                                                 @endif
                                             </td>
                                             <td>
                                                 @if ($followup && $followup->status)
                                                     {{ $followup->note }}
                                                 @else
                                                         <textarea class="form-control form-control-sm"
                                                                     id="note_{{ $followup->id }}"
                                                                     name="note_{{ $followup->id }}"
                                                                     style="height: auto"
                                                                     {{ $followup && $followup->status ? 'disabled' : '' }}>
                                                         </textarea>
                                                     </div>
                                                 @endif
                                             </td>
                                             <td>
                                                 <div class="text-center">
                                                     <button type="button" class="btn btn-sm btn-primary update-btn"
                                                                         id="update_{{ $followup->id }}"
                                                                         data-id="{{ $followup->id }}" {{ $followup->status ? 'disabled' : '' }}>
                                                                     <i class="fas fa-check"></i>
                                                                 </button>

                                                                 <form action="{{ route('followups.destroy', $followup->id) }}" method="POST" style="display:inline;">
                                                                   @csrf
                                                                   @method('DELETE')
                                                                   <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                                           onclick="return confirm('Are you sure you want to delete this follow-up?');">
                                                                           <i class="fas fa-trash"></i>
                                                                   </button>
                                                             </form>
                                                 </div>
                                             </td>
                                         </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                                </div>

                                <!-- Missed Follow-ups Tab -->
                                <div class="tab-pane fade" id="missed" role="tabpanel" aria-labelledby="missed-tab">
                                    <table class="table table-bordered table-striped" id="dataTableMissed" cellspacing="0">
                                        <thead class="bg-light text-dark">
                                         <tr>
                                             <th>S.No</th>
                                             <th>Enquiry ID</th>
                                             <th>Follow-up Date</th>
                                             <th>Follow-up Time</th>
                                             <th>Follow-up Type</th>
                                             <th>Remark</th>
                                             <th>Updated By</th>
                                             <th>Note</th>
                                             <th>Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($followupsMissed as $followup)
                                         <tr class="{{ $followup && $followup->status ? 'table-success' : '' }}">
                                             <td>{{ $loop->iteration }}</td>
                                             <td>{{ $followup->enquiry_id}}</td>
                                             <td>{{ $followup->fdate->format('d-m-Y') }}</td>
                                             <td>{{ $followup->ftime }}</td>
                                             <td>{{ $followup->type }}</td>
                                             <td>{{ $followup->remark }}</td>
                                             <td>
                                                 @if ($followup->updatedBy)
                                                     {{ $followup->updatedBy->first_name ?? 'N/A' }} {{ $followup->updatedBy->last_name ?? 'N/A' }}
                                                 @else
                                                      N/A
                                                 @endif
                                             </td>
                                             <td>
                                                 @if ($followup && $followup->status)
                                                     {{ $followup->note }}
                                                 @else
                                                         <textarea class="form-control form-control-sm"
                                                                     id="note_{{ $followup->id }}"
                                                                     name="note_{{ $followup->id }}"
                                                                     style="height: auto"
                                                                     {{ $followup && $followup->status ? 'disabled' : '' }}>
                                                         </textarea>
                                                     </div>
                                                 @endif
                                             </td>
                                             <td>
                                                 <div class="text-center">
                                                     <button type="button" class="btn btn-sm btn-primary update-btn"
                                                                         id="update_{{ $followup->id }}"
                                                                         data-id="{{ $followup->id }}" {{ $followup->status ? 'disabled' : '' }}>
                                                                     <i class="fas fa-check"></i>
                                                                 </button>

                                                                 <form action="{{ route('followups.destroy', $followup->id) }}" method="POST" style="display:inline;">
                                                                   @csrf
                                                                   @method('DELETE')
                                                                   <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                                           onclick="return confirm('Are you sure you want to delete this follow-up?');">
                                                                           <i class="fas fa-trash"></i>
                                                                   </button>
                                                             </form>
                                                 </div>
                                             </td>
                                         </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                                </div>
                            </div>

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

    <!-- Enquiry Details Modal -->
    <div class="modal fade" id="enquiryDetailsModal" tabindex="-1" aria-labelledby="enquiryDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enquiryDetailsModalLabel">Enquiry Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded dynamically -->
                    <div id="enquiryDetailsContent">
                        <p class="text-center">Loading...</p>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td><strong>Customer</strong> </td>
                                <td id="view_name"></td>

                                <td><strong>Date</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Mobile</strong></td>
                                <td></td>

                                <td><strong>Whatsapp</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td></td>
                                <td><strong>Address</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Priority</strong></td>
                                <td></td>
                                <td><strong>Service</strong></td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td id="view_status"></td>
                                <td><strong>Notes</strong></td>
                                <td id="view_note"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const updateButtons = document.querySelectorAll('.update-btn');

            updateButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const fid = $(this).data('id');
                    const note = document.querySelector(`#note_${fid}`);

                    // Disable button to prevent multiple clicks
                    this.disabled = true;

                    // Get the CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Make the fetch request to update the service
                    fetch('{{ route("followups.updatestatus") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            id: fid,
                            note: note ? note.value.trim() : ''
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const messageBox = document.createElement('div');
                        messageBox.className = 'popup-message';
                        if (data.success) {
                            messageBox.innerText = 'Followup updated successfully!';
                            const tableRow = document.querySelector(`button[data-id="${fid}"]`).closest('tr');
                                if (tableRow) {
                                    tableRow.classList.add('table-success');
                                }
                        } else {
                            messageBox.innerText = 'Failed to update service: ' + data.message;
                            messageBox.classList.add('error');
                        }
                        document.body.appendChild(messageBox);

                        setTimeout(() => {
                            messageBox.remove();
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the followup.');
                    });
                });
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const enquiryLinks = document.querySelectorAll('.enquiry-details-link');

        enquiryLinks.forEach(link => {
            link.addEventListener('click', function () {
                const enquiryId = this.getAttribute('data-id');
                const modalContent = document.getElementById('enquiryDetailsContent');

                // Show loading state
                modalContent.innerHTML = '<p class="text-center">Loading...</p>';

                // Make an AJAX request to fetch enquiry details
                fetch(`/enquiries/${enquiryId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch enquiry details.');
                        }
                        return response.json(); // Parse response as JSON
                    })
                    .then(data => {
                        // Populate the modal with fetched content
                        let name = `${data.fname} ${data.lname}`;
                        let note = `${data.note}`;
                        console.log(name);

                        $('#view_name').text(name);
                        $('#view_whatsapp').text(data.whatsapp ? data.whatsapp : 'N/A');
                        $('#view_mobile').text(data.mobile ? data.mobile : 'N/A');
                        $('#view_email').text(data.email ? data.email : 'N/A');
                        $('#view_address').text(data.address ? data.address : 'N/A');
                        $('#view_priority').text(data.priority ? data.priority : 'N/A');
                        $('#view_note').text(note);
                        $('#added_by').text(
                            data.added_by
                                ? `${data.added_by.first_name} ${data.added_by.last_name}`
                                : 'N/A'
                        );
                        $('#accept_button').attr('data-enquiry-id', data.id);

                        $('#view_service').empty();

                        if (data.services && data.services.length > 0) {
                            $.each(data.services, function (index, service) {
                                $('#view_service').append(`<span>${service.name}</span><br>`);
                            });
                        } else {
                            $('#view_service').text('N/A');
                        }

                        $('#viewEnquiryModal').modal('show');
                    })
                    .catch(error => {
                        console.error(error);
                        modalContent.innerHTML = '<p class="text-danger text-center">Failed to load enquiry details.</p>';
                    });
            });
        });
    });
</script>





@endsection
