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
                        <h3 class="font-weight-bold text-primary">Employee List</h3>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Employee Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-right mb-3"><a class="btn btn-primary btn-sm" href="{{route('user.create')}}">Add Employee</a></div>
                            <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                     <thead class="bg-light text-dark">
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Whatsapp</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                        <th>Manage Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->whatsapp }}</td>
                                            <td>{{ $user->email }}</td>

                                            <td>
                                                <div class="text-center">
                                                    <!-- Dropdown button -->
                                                    <div class="dropdown">
                                                        <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                                            <li>
                                                                <a class="dropdown-item text-success" href="{{ route('user.show', $user->id) }}">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-primary" href="{{ route('user.edit', $user->id) }}">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                                                        <i class="fa-solid fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <button class="text-success border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#permissionsModal{{ $user->id }}">
                                                        <i class="fa-solid fa-user-check"></i>
                                                    </button>
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
    {{-- @foreach ($users as $user)
    <!-- Permissions Modal -->
    <div class="modal fade" id="permissionsModal{{ $user->id }}" tabindex="-1" aria-labelledby="permissionsModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel{{ $user->id }}">Manage Permissions for {{ $user->first_name }}</h5>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.updatePermissions', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="permissions">Permissions</label>
                            <div>
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission }}"
                                        {{ in_array($permission, json_decode($user->permissions ?? '[]')) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ ucfirst($permission) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach --}}
@endsection
