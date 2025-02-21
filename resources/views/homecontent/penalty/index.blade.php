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
                        <h3 class=" font-weight-bold text-primary">Penalty List</h3>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Penalty Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-right p-2 mb-3 ">
                                <a href="{{ route('penalties.create') }}" class="btn btn-primary btn-sm"> Add Penalty </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                         <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr no</th>
                                            <th>User</th>
                                            <th>Enquiry</th>
                                            <th>Booking</th>
                                            <th>Amount</th>
                                            <th>Reason</th>
                                            <th>Added By</th>
                                            <th>Updated By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($penalties as $penalty)
                                            <tr>
                                                <td>{{ $penalty->id }}</td>
                                                <td>{{ $penalty->user->first_name ?? 'N/A' }}</td>
                                                <td>{{ $penalty->enquiry->name ?? 'N/A' }}</td>
                                                <td>{{ $penalty->booking->customer->name ?? 'N/A' }}</td>
                                                <td>{{ $penalty->amount }}</td>
                                                <td>{{ $penalty->reason }}</td>
                                                <td>{{ $penalty->addedBy->first_name ?? 'N/A' }}</td>
                                                <td>{{ $penalty->updatedBy->first_name ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $penalty->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $penalty->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-primary" href="{{ route('penalties.edit', $penalty->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('penalties.destroy', $penalty->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this penalty?');">
                                                                            <i class="fa-solid fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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



@endsection
