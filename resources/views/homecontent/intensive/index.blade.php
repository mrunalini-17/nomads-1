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
                        <h3 class=" font-weight-bold text-primary">Incentives List</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="text-right p-2">
                            {{-- <a href="{{route('intensive.create')}}" class="btn btn-primary btn-sm"> Add Incentive </a> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                         <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr no</th>
                                            <th>User</th>
                                            <th>Enquiry Name</th>
                                            <th>Booking Customer Name</th>
                                            <th>Amount</th>
                                            <th>Timestamp</th>
                                            <th>Added By</th>
                                            <th>Updated By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($intensives as $intensive)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $intensive->user->first_name }} {{ $intensive->user->last_name }}
                                                </td>
                                                <td>{{ $intensive->enquiry->name }}</td>
                                                <td>{{ $intensive->booking->customer->name }}</td>
                                                <td>{{ $intensive->amount }}</td>
                                                <td>{{ $intensive->timestamp }}</td>
                                                <td>
                                                    @if ($intensive->addedBy)
                                                        {{ $intensive->addedBy->first_name ?? 'N/A' }}
                                                        {{ $intensive->addedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($intensive->updatedBy)
                                                        {{ $intensive->updatedBy->first_name ?? 'N/A' }}
                                                        {{ $intensive->updatedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $intensive->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $intensive->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-primary" href="{{ route('intensive.edit', $intensive->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('intensive.destroy', $intensive->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this Intensive?');">
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
