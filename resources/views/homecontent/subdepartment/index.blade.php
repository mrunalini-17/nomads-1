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
                        <h3 class=" font-weight-bold text-primary">Sub-department List</h3>
                    </div>



                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        {{-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Sub-department</h6>
                        </div> --}}
                        <div class="card-body">
                            <div class="text-right mb-3">
                                <a href="{{route('subdepartment.create')}}" class="btn btn-primary btn-sm"> Add Sub-Department </a>
                            </div>
                            <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                     <thead class="bg-light text-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Department</th>
                                        <th>Sub-department Name</th>
                                        <th>Added by</th>
                                        <th>Updated by</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subDepartments as $subDepartment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $subDepartment->department->department_name }}</td>
                                            <td>{{ $subDepartment->name }}</td>
                                            <td>
                                                @if ($subDepartment->addedBy)
                                                    {{ $subDepartment->addedBy->first_name ?? 'N/A' }}
                                                    {{ $subDepartment->addedBy->last_name ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($subDepartment->updatedBy)
                                                    {{ $subDepartment->updatedBy->first_name ?? 'N/A' }}
                                                    {{ $subDepartment->updatedBy->last_name ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            {{-- <td>
                                                <div class="text-center">
                                                    <!-- View Button -->
                                                    <a  class="btn btn-sm btn-success" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $subDepartment->id }}" title="View">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('subdepartment.edit', $subDepartment->id) }}" class="btn btn-sm btn-primary edit-card-btn" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <form action="{{ route('subdepartment.destroy', $subDepartment->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this Department?');">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td> --}}
                                            <td>
                                                <div class="text-center">
                                                    <!-- Dropdown button -->
                                                    <div class="dropdown">
                                                        <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $subDepartment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $subDepartment->id }}">
                                                            <li>
                                                                <a class="dropdown-item text-success view-subdept-btn"
                                                                   href="javascript:void(0);"
                                                                   data-dept-name="{{ $subDepartment->department->department_name }}"
                                                                   data-name="{{ $subDepartment->name }}">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item text-primary edit-subdept-btn"
                                                                            data-card='@json($subDepartment)'>
                                                                        <i class="fa-solid fa-edit"></i> Edit
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('subdepartment.destroy', $subDepartment->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this source?');">
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
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            @include('shared.footer')

        </div>
        <!-- End of Content Wrapper -->


                <!-- View Card Modal -->
                <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewModalLabel">Sub-department Details</h6>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Department Name</th>
                                            <td id="modalDeptName"></td>
                                        </tr>
                                        <tr>
                                            <th>Sub-department Name</th>
                                            <td id="modalSubdeptName"></td>
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
                                <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewModalLabel">Edit Sub-department</h6>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label for="edit_dept_id" class="form-label">Department Name</label>
                                            <select class="form-control" id="edit_dept_id" name="department_id" required>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="edit_card_number" class="form-label">Sub-department Name</label>
                                            <input type="text" class="form-control" id="edit_name" name="name" required>
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

                <!-- Create Card Modal -->
                <div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title m-0 font-weight-bold text-primary" id="addCardModalLabel">Add Card</h6>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('cards.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label for="card_name" class="form-label">Card Name</label>
                                            <input type="text" class="form-control" id="card_name" name="card_name" required>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="card_number" class="form-label">Card Number</label>
                                            <input type="number" class="form-control" id="card_number" name="card_number" required>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="expiry_date" class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
                                            <small class="text-muted">e.g. Aug 2026, Jun 2028</small>
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

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>




        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all view buttons
                const viewButtons = document.querySelectorAll('.view-subdept-btn');

                viewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Get the card data from data attributes
                        const deptName = this.getAttribute('data-dept-name');
                        const subdeptNumber = this.getAttribute('data-name');

                        // Populate the modal with the card data
                        document.getElementById('modalDeptName').textContent = deptName;
                        document.getElementById('modalSubdeptName').textContent = subdeptNumber;

                        // Show the modal
                        const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                        viewModal.show();
                    });
                });


                // Edit modal handle
                const editModal = document.getElementById('editModal');
                const deptIDInput = document.getElementById('edit_dept_id');
                const nameInput = document.getElementById('edit_name');
                const editForm = document.getElementById('editForm');

                document.querySelectorAll('.edit-subdept-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const subDepartment = JSON.parse(this.getAttribute('data-card'));


                        deptIDInput.value = subDepartment.department_id;
                        nameInput.value = subDepartment.name;
                        editForm.action = `/subdepartment/${subDepartment.id}/update`;

                        const modal = new bootstrap.Modal(editModal);
                        modal.show();
                    });
                });

            });
        </script>



@endsection
