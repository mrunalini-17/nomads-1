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
                    <div class=" py-3 px-2">
                        <h3 class=" font-weight-bold text-primary">Services List</h3>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Service</h6>
                        </div>
                        <div class="card-body">
                                <div class="text-right mb-3">
                                    <a href="{{route('services.create')}}" class="btn btn-primary btn-sm"> Add Service </a>
                                </div>
                            <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                     <thead class="bg-light text-dark">
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Added By</th>
                                        <th>Updated By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ $service->description }}</td>
                                            <td>
                                                @if($service->is_active == 1)
                                                    <span style="color: green;">Active</span>
                                                @else
                                                    <span style="color: red;">Inactive</span>
                                                @endif
                                            </td>

                                            <td>{{ optional($service->addedBy)->first_name ?? 'NA' }} {{ optional($service->addedBy)->last_name ?? '' }}</td>
                                            <td>{{ optional($service->updatedBy)->first_name ?? 'NA' }} {{ optional($service->updatedBy)->last_name ?? '' }}</td>
                                            <td>
                                                <div class="text-center">
                                                    <!-- Dropdown button -->
                                                    <div class="dropdown">
                                                        <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $service->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $service->id }}">
                                                            {{-- <li>
                                                                <a class="dropdown-item text-success" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $service->id }}">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </a>
                                                            </li> --}}
                                                            <li>
                                                                <a class="dropdown-item text-primary" href="{{ route('services.edit', $service->id) }}">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this Service?');">
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

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



@endsection
