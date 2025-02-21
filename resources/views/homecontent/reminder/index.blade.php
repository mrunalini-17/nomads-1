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
                        <h3 class=" font-weight-bold text-primary">Reminder List</h3>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reminder Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-right p-2 mb-3 ">
                                {{-- <a href="{{ route('reminders.create') }}" class="btn btn-primary btn-sm"> Add Reminder </a> --}}
                            </div>
                            <table class="table table-bordered table-responsive" id="dataTable" cellspacing="0">
                                <thead class="bg-light text-dark">
                                    <tr>
                                        <th>Sr no</th>
                                        <th>Customer</th>
                                        <th>User</th>
                                        <th>Message</th>
                                        <th>Reason</th>
                                        <th>Message Read</th>
                                        <th>Message Read By</th>
                                        <th>Booking</th>
                                        <th>Added By</th>
                                        <th>Updated By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($reminders as $reminder)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ optional($reminder->customer)->name ?? 'N/A' }}</td>
                                            <td>{{ optional($reminder->user)->first_name . ' ' . optional($reminder->user)->last_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $reminder->message }}</td>
                                            <td>{{ $reminder->reason }}</td>
                                            <td>{{ $reminder->message_read ? 'Yes' : 'No' }}</td>
                                            <td>{{ optional($reminder->messageReadByUser)->first_name . ' ' . optional($reminder->messageReadByUser)->last_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ optional($reminder->booking->customer)->name ?? 'N/A' }}</td>
                                            <td>{{ optional($reminder->addedBy)->first_name . ' ' . optional($reminder->addedBy)->last_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ optional($reminder->updatedBy)->first_name . ' ' . optional($reminder->updatedBy)->last_name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <div class="dropdown">
                                                        <button class="text-info border-0 bg-transparent dropdown-toggle"
                                                            type="button" id="dropdownMenuButton{{ $reminder->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $reminder->id }}">
                                                            <li>
                                                                <a class="dropdown-item text-primary"
                                                                    href="{{ route('reminders.edit', $reminder->id) }}">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('reminders.destroy', $reminder->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item text-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this reminder?');">
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
