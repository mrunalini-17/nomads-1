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
                        <h3 class="font-weight-bold text-primary">Create Followups</h3>
                    </div>
                    <div class="text-right p-2">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">
                            Back
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Followups</h6>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('followups.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="enquiry_id" class="form-label">Enquiry</label>
                                        <input type="text" class="form-control" id="enquiry_id" name="enquiry_id" value="{{old('enquiry_id')}}" required>
                                        <small class="text-muted">*Kindly input the enquiry ID</small>
                                        {{-- <select name="enquiry_id" id="enquiry_id" class="form-control">
                                            <option value="">Select Enquiry</option>
                                            @foreach ($enquiries as $enquiry)
                                                <option value="{{ $enquiry->id }}">{{ $enquiry->unique_code}}</option>
                                            @endforeach
                                        </select> --}}
                                        @error('enquiry_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-md-6">
                                        <label for="user_id" class="form-label">User</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group col-md-6">
                                        <label for="followup_date" class="form-label">Follow-up Date</label>
                                        <input type="date" class="form-control" id="fdate" name="fdate" value="{{old('fdate')}}" required>
                                        @error('fdate')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="followup_time" class="form-label">Follow-up Time</label>
                                        <input type="time" class="form-control" id="ftime" name="ftime" value="{{old('ftime')}}" required>
                                        @error('ftime')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3">{{old('remark')}}</textarea>
                                        @error('remark')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="followup_type" class="form-label">Follow-up Type</label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="Routine Follow-up" {{ old('type') === "Routine Follow-up" ? 'selected' : '' }}>Routine Follow-up</option>
                                            <option value="Schedule Meeting" {{ old('type') === "Schedule Meeting" ? 'selected' : '' }}>Schedule Meeting</option>
                                        </select>
                                        @error('type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div> --}}
                                </div>
                        </div>
                        <div class="card-footer mt-4 text-center">
                            <button type="submit" class="btn btn-success">Submit</button>
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
