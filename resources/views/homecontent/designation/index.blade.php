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
                        <h3 class="font-weight-bold text-primary">Designation List</h3>
                    </div>

                    {{-- <div class="text-right p-2">
                        <a href={{ route('designation.create') }} class="btn btn-primary"> <i class="fa-solid fa-plus"></i> Create Designation </a>
                    </div> --}}

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">

                            <div class="text-right mb-3"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addModal"> Create Designation</button></div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                       <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Designation Name</th>
                                            <th>Description</th>
                                            <th>Added by</th>
                                            <th>Updated by</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($designations as $designation)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $designation->designation_name }}</td>
                                                <td>{{ $designation->description ?: '--'}}</td>
                                                <td>
                                                    @if ($designation->addedBy)
                                                        {{ $designation->addedBy->first_name ?? 'N/A' }}
                                                        {{ $designation->addedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($designation->updatedBy)
                                                        {{ $designation->updatedBy->first_name ?? 'N/A' }}
                                                        {{ $designation->updatedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="text-info border-0 bg-transparent dropdown-toggle"
                                                                type="button" id="dropdownMenuButton{{ $designation->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton{{ $designation->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-success view-design-btn"
                                                                       href="javascript:void(0);"
                                                                       data-design-name="{{ $designation->designation_name }}"
                                                                       data-description="{{ $designation->description }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    {{-- <a class="dropdown-item text-primary"
                                                                        href="{{ route('designation.edit', $department->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a> --}}
                                                                    <button class="dropdown-item text-primary edit-design-btn"
                                                                            data-card='@json($designation)'>
                                                                        <i class="fa-solid fa-edit"></i> Edit
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('designation.destroy', $designation->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger"
                                                                            onclick="return confirm('Are you sure you want to delete this designation?');">
                                                                            <i class="fa-solid fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton{{ $designation->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $designation->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-success" href="#"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#viewModal{{ $designation->id }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-primary"
                                                                       href="{{ route('designation.edit', $designation->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('designation.destroy', $designation->id) }}"
                                                                          method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger"
                                                                                onclick="return confirm('Are you sure you want to delete this Designation?');">
                                                                            <i class="fa-solid fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td> --}}
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

            <!-- View Modal -->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewModalLabel">Designation Details</h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Designation Name</th>
                                        <td id="modalDesignationName"></td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td id="modalDescription"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0 font-weight-bold text-primary" id="editModalLabel">Edit Designation</h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label for="edit_designation_name" class="form-label">Designation Name</label>
                                        <input type="text" class="form-control" id="edit_designation_name" name="designation_name" required>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="edit_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="edit_description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title m-0 font-weight-bold text-primary" id="addModalLabel">Create Designation</h6>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('designation.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-12">
                                        <label for="card_name" class="form-label">Designation Name</label>
                                        <input type="text" class="form-control" id="designation_name" name="designation_name" required>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="text-center">
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
                document.addEventListener('DOMContentLoaded', function() {
                    // Get all view buttons
                    const viewButtons = document.querySelectorAll('.view-design-btn');

                    viewButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Get the card data from data attributes
                            const designName = this.getAttribute('data-design-name');
                            const description = this.getAttribute('data-description') || '--';

                            // Populate the modal with the card data
                            document.getElementById('modalDesignationName').textContent = designName;
                            document.getElementById('modalDescription').textContent = description;

                            // Show the modal
                            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                            viewModal.show();
                        });
                    });


                    // Edit modal handle
                    const editModal = document.getElementById('editModal');
                    const nameInput = document.getElementById('edit_designation_name');
                    const descriptionInput = document.getElementById('edit_description');
                    const editForm = document.getElementById('editForm');

                    document.querySelectorAll('.edit-design-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const design = JSON.parse(this.getAttribute('data-card'));

                            // Fill the modal with the card data
                            nameInput.value = design.designation_name;
                            descriptionInput.value = design.description || '';

                            // Update form action to the correct route
                            editForm.action = `/designation/${design.id}/update`;

                            // Show the modal
                            new bootstrap.Modal(editModal).show();
                        });
                    });
                });
            </script>



@endsection
