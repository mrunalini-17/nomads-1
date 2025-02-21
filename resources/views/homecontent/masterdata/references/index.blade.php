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
                    <div class=" py-3 px-2">
                        <h3 class=" font-weight-bold text-primary">References List</h3>
                    </div>

                    <div class="text-right p-2">
                        {{-- <a href="{{route('references.create')}}" class="btn btn-primary"> <i class="fa-solid fa-plus"></i>Add Reference </a> --}}
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="text-right mb-3">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createReferenceModal"> Add Reference</button>
                            </div>


                            <div class="table-responsive">

                                <table class="table " id="dataTable" cellspacing="0">
                                    <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr no</th>
                                            <th>Reference Name</th>
                                            <th>Mobile</th>
                                            <th>Whatsapp</th>
                                            <th>Email</th>
                                            <th>GST No</th>
                                            <th>Description</th>
                                            <th>Added by</th>
                                            <th>Updated by</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($references as $reference)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $reference->name ?: '--' }}</td>
                                                <td>{{ $reference->mobile }}</td>
                                                <td>{{ $reference->whatsapp }}</td>
                                                <td>{{ $reference->email }}</td>
                                                <td>{{ $reference->gstin }}</td>
                                                <td>{{ $reference->description ?: '--' }}</td>
                                                <td>
                                                    @if ($reference->addedBy)
                                                        {{ $reference->addedBy->first_name ?? 'N/A' }}
                                                        {{ $reference->addedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($reference->updatedBy)
                                                        {{ $reference->updatedBy->first_name ?? 'N/A' }}
                                                        {{ $reference->updatedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <div class="text-center">
                                                        <!-- View Button -->
                                                        <a class="btn btn-sm btn-success" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $reference->id }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>

                                                        <!-- Edit Button -->

                                                            <a class="btn btn-sm btn-primary edit-ref-btn" href="#" data-id="{{ $reference->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('references.destroy', $reference->id) }}" method="POST" style="display:inline;">

                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this card?');">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td> --}}


                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="text-info border-0 bg-transparent dropdown-toggle"
                                                                type="button" id="dropdownMenuButton{{ $reference->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton{{ $reference->id }}">
                                                                {{-- <li>
                                                                    <a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $reference->id }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li> --}}
                                                                <li>
                                                                    <a class="dropdown-item text-primary edit-ref-btn" href="#" data-id="{{ $reference->id }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('references.destroy', $reference->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this reference?');">
                                                                            <i class="fa-solid fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
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
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Add Modal Structure -->
            <div class="modal fade" id="createReferenceModal" tabindex="-1" role="dialog" aria-labelledby="createReferenceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="createReferenceModalLabel">Add Reference</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <!-- Form content here -->
                        <form action="{{ route('references.store') }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">Name <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter reference name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="whatsapp" class="col-md-4 col-form-label">Whatsapp <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" min="0">
                                    @error('whatsapp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label">Mobile No <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" min="0">
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">Email </label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gstin" class="col-md-4 col-form-label">GST No</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control @error('gstin') is-invalid @enderror" id="gstin" name="gstin" value="{{ old('gstin') }}">
                                    @error('gstin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label">Description</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="description" rows="3" class="form-control">{{ old('description')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                </div>
            </div>

            <!-- Edit Modal Structure -->
            <div class="modal fade" id="editReferenceModal" tabindex="-1" role="dialog" aria-labelledby="editReferenceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editReferenceModalLabel">Edit Reference</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form id="editReferenceForm" action="{{ route('references.update') }}" method="POST">
                                @csrf
                                <input type="hidden" id="editReferenceId" name="id">

                                <div class="form-group row">
                                    <label for="editName" class="col-md-4 col-form-label">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="editName" name="name" placeholder="Enter reference name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="editwhatsapp" class="col-md-4 col-form-label">Whatsapp <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control @error('editwhatsapp') is-invalid @enderror" id="editwhatsapp" name="whatsapp"  min="0">
                                        @error('editwhatsapp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="editmobile" class="col-md-4 col-form-label">Mobile No <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control @error('editmobile') is-invalid @enderror" id="editmobile" name="mobile"  min="0">
                                        @error('editmobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="editemail" class="col-md-4 col-form-label">Email </label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control @error('editemail') is-invalid @enderror" id="editemail" name="email">
                                        @error('editemail')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="editgstin" class="col-md-4 col-form-label">GST No</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control @error('editgstin') is-invalid @enderror" id="editgstin" name="gstin" >
                                        @error('editgstin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="edescription" class="col-md-4 col-form-label">Description</label>
                                    <div class="col-md-8">
                                        <textarea name="description" id="edescription" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



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

<script>
        $(document).ready(function() {

            new DataTable('#dataTable', {
                responsive: true
            });
            $('.edit-ref-btn').on('click', function(e) {
                e.preventDefault();
                var refId = $(this).data('id');
                console.log(refId);
                console.log("test")
                // return;
                $.ajax({
                    url: '/references/edit/' + refId,
                    method: 'GET',
                    success: function(response) {
                        $('#editReferenceId').val(response.id);
                        $('#editName').val(response.name);
                        $('#editmobile').val(response.mobile);
                        $('#editwhatsapp').val(response.whatsapp);
                        $('#editgstin').val(response.gstin);
                        $('#editemail').val(response.email);
                        $('#edescription').val(response.description);

                        // Show the modal
                        $('#editReferenceModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            });

                // Event listener for the close button in the modal header
                $('#editReferenceModal .close').on('click', function() {
                    console.log('Close button in the header clicked');
                    // $('#editReferenceModal').modal('hide');
                });

                // Event listener for the close button in the modal footer
                $('#editReferenceModal .btn-secondary').on('click', function() {
                    $('#editReferenceModal').modal('hide');
                    // console.log('Close button in the footer clicked');
                });
        });


    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#createReferenceModal form');
        const nameInput = document.getElementById('name');
        const mobileInput = document.getElementById('mobile');
        const whatsappInput = document.getElementById('whatsapp');

        form.addEventListener('submit', function (event) {
            let valid = true;

            // Clear previous error messages
            clearErrors();

            // Validate Name
            if (nameInput.value.trim() === '') {
                showError(nameInput, 'Reference Name is required');
                valid = false;
            }

            // Validate Mobile Number
            const mobileValue = mobileInput.value.trim();
            if (mobileValue.length !== 10 || !/^\d{10}$/.test(mobileValue)) {
                showError(mobileInput, 'Mobile Number must be exactly 10 digits long');
                valid = false;
            }

            const whatsappValue = whatsappInput.value.trim();
            if (whatsappValue.length !== 10 || !/^\d{10}$/.test(whatsappValue)) {
                showError(whatsappInput, 'Whatsapp Number must be exactly 10 digits long');
                valid = false;
            }

            // Prevent form submission if validation fails
            if (!valid) {
                event.preventDefault();
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
    });

</script>
@endsection
