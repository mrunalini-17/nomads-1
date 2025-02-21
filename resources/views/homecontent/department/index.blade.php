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
                        <h3 class=" font-weight-bold text-primary">Department List</h3>
                    </div>

                    <div class="text-right p-2">
                        {{-- <a href="{{route('department.create')}}" class="btn btn-primary"> <i class="fa-solid fa-plus"></i> Create Department </a> --}}
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            {{-- <div class="text-right mb-3"><a  class="btn btn-primary btn-sm px-3 py-2" href="{{route('department.create')}}">Create Department</a></div> --}}
                            <div class="text-right mb-3"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDepartmentModal"> Create Department</button></div>


                            <div class="table-responsive">

                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                       <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr no</th>
                                            <th>Department</th>
                                            <th>Description</th>
                                            <th>Added by</th>
                                            <th>Updated by</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $department->department_name }}</td>
                                                <td>{{ $department->description ?: '--'}}</td>
                                                <td>
                                                    @if ($department->addedBy)
                                                        {{ $department->addedBy->first_name ?? 'N/A' }}
                                                        {{ $department->addedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($department->updatedBy)
                                                        {{ $department->updatedBy->first_name ?? 'N/A' }}
                                                        {{ $department->updatedBy->last_name ?? 'N/A' }}
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
                                                                type="button" id="dropdownMenuButton{{ $department->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton{{ $department->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-success view-dept-btn"
                                                                       href="javascript:void(0);"
                                                                       data-dept-name="{{ $department->department_name }}"
                                                                       data-description="{{ $department->description }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    {{-- <a class="dropdown-item text-primary"
                                                                        href="{{ route('department.edit', $department->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a> --}}
                                                                    <button class="dropdown-item text-primary edit-dept-btn"
                                                                            data-card='@json($department)'>
                                                                        <i class="fa-solid fa-edit"></i> Edit
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('department.destroy', $department->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger"
                                                                            onclick="return confirm('Are you sure you want to delete this Department?');">
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
                                                        <!-- View Button -->
                                                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewModal{{ $department->id }}" title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('department.edit', $department->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <!-- Delete Button -->
                                                        <form action="{{ route('department.destroy', $department->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this Department?');">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
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

        <!-- View Department Modal -->
        <div class="modal fade" id="viewDepartmentModal" tabindex="-1" aria-labelledby="viewDepartmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title" id="viewDepartmentModalLabel">Department Details</h5> --}}
                        <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewDepartmentModalLabel">Department Details</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Department Name</th>
                                    <td id="modalDepartmentName"></td>
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

        <!-- Edit Department Modal -->
        <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0 font-weight-bold text-primary" id="editDepartmentModalLabel">Edit Department</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="editDepartmentForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label for="edit_department_name" class="form-label">Department Name</label>
                                    <input type="text" class="form-control" id="edit_department_name" name="department_name" required>
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

        <!-- Create Department Modal -->
        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0 font-weight-bold text-primary" id="addDepartmentModalLabel">Add Department</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('department.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label for="card_name" class="form-label">Department Name</label>
                                    <input type="text" class="form-control" id="department_name" name="department_name" required>
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
                const viewButtons = document.querySelectorAll('.view-dept-btn');

                viewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Get the card data from data attributes
                        const deptName = this.getAttribute('data-dept-name');
                        const description = this.getAttribute('data-description') || '--';

                        // Populate the modal with the card data
                        document.getElementById('modalDepartmentName').textContent = deptName;
                        document.getElementById('modalDescription').textContent = description;

                        // Show the modal
                        const viewDepartmentModal = new bootstrap.Modal(document.getElementById('viewDepartmentModal'));
                        viewDepartmentModal.show();
                    });
                });


                // Edit modal handle
                const editModal = document.getElementById('editDepartmentModal');
                const nameInput = document.getElementById('edit_department_name');
                const descriptionInput = document.getElementById('edit_description');
                const editForm = document.getElementById('editDepartmentForm');

                document.querySelectorAll('.edit-dept-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const dept = JSON.parse(this.getAttribute('data-card'));

                        // Fill the modal with the card data
                        nameInput.value = dept.department_name;
                        descriptionInput.value = dept.description || '';

                        // Update form action to the correct route
                        editForm.action = `/department/${dept.id}/update`;

                        // Show the modal
                        new bootstrap.Modal(editDepartmentModal).show();
                    });
                });
            });
        </script>



@endsection
