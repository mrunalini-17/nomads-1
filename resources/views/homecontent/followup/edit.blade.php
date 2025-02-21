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
                        <h3 class="font-weight-bold text-primary">Edit Followups</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                            Back
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Followups Details</h6>
                        </div>
                        <div class="card-body">

                                <form action="{{ route('followups.update', $followup->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col col-6 mb-3">
                                            <label for="enquiry_id">Enquiry</label>
                                            <select name="enquiry_id" id="enquiry_id" class="form-control form-select" required>
                                                <option value="">Select Enquiry</option>
                                                @foreach ($enquiries as $enquiry)
                                                    <option value="{{ $enquiry->id }}" {{ $enquiry->id == $followup->enquiry_id ? 'selected' : '' }}>
                                                        {{ $enquiry->fname }} {{ $enquiry->lname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col col-6 mb-3">
                                            <label for="user_id">User</label>
                                            <select name="user_id" id="user_id" class="form-control form-select" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $user->id == $followup->user_id ? 'selected' : '' }}>
                                                        {{ $user->first_name }} {{ $user->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col col-6 mb-3">
                                            <label for="followup_date">Follow-Up Date</label>
                                            <input type="date" name="followup_date" id="followup_date" class="form-control" value="{{ old('followup_date', $followup->followup_date) }}" required>
                                        </div>

                                        <div class="form-group col col-6 mb-3">
                                            <label for="followup_time">Follow-Up Time</label>
                                            <input type="time" name="followup_time" id="followup_time" class="form-control" value="{{ old('followup_time', $followup->followup_time) }}">
                                        </div>

                                        <div class="form-group col col-6 mb-3">
                                            <label for="remarks">Remarks</label>
                                            <textarea name="remarks" id="remarks" class="form-control" rows="4">{{ old('remarks', $followup->remarks) }}</textarea>
                                        </div>

                                        <div class="form-group col col-6 mb-3">
                                            <label for="followup_type">Follow-Up Type</label>
                                            <select name="followup_type" id="followup_type" class="form-control form-select" required>
                                                <option value="routine_followup" {{ $followup->followup_type == 'routine_followup' ? 'selected' : '' }}>Routine Follow-Up</option>
                                                <option value="schedule_meeting" {{ $followup->followup_type == 'schedule_meeting' ? 'selected' : '' }}>Schedule Meeting</option>
                                            </select>
                                        </div>

                                        <div class="form-group col col-6 mb-3">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control form-select" required>
                                                <option value="active" {{ $followup->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $followup->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>



                        </div>
                        <div class="card-footer mt-4 text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
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
