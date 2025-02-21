@extends('layout.app')

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
                        <h3 class="font-weight-bold text-primary">View Customer</h3>
                    </div>

                    <!-- DataTales Example -->
                    <div class="row">
                        <div class="col-lg-12">
                                {{-- Head --}}

                            <div class="card">
                                <div class="card-body card-bodycolor">
                                    <div class="text-right p-3">
                                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-sm"> Back</a>
                                    </div>
                                    <!-- Customer Details -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title">Customer Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $customer->fname }} {{ $customer->lname }}</td>
                                                    <th>Email</th>
                                                    <td>{{ $customer->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mobile</th>
                                                    <td>{{ $customer->mobile }}</td>
                                                    <th>WhatsApp</th>
                                                    <td>{{ $customer->whatsapp }}</td>
                                                </tr>

                                                    <th>Address</th>
                                                    @php
                                                            $address = implode(', ', array_filter([
                                                                $customer->locality,
                                                                optional($customer->city)->name,
                                                                optional($customer->state)->name,
                                                                optional($customer->country)->name,
                                                                $customer->pincode,
                                                            ]));
                                                        @endphp
                                                    <td>{{ $address }}</td>
                                                    <th>Reference</th>
                                                    <td>{{ $customer->reference->name ?? '';}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Has Manager</th>
                                                    <td class="d-flex justify-content-between align-items-center">
                                                        <span>{{ $customer->have_manager ? 'Yes' : 'No' }}</span>
                                                        {{-- <a href="{{ route('customer-managers.create', $customer->id) }}" class="btn btn-success btn-sm ms-3">Add Manager</a> --}}
                                                    </td>
                                                    <th>Has Company</th>
                                                    <td class="d-flex justify-content-between align-items-center">
                                                        <span>{{ $customer->have_company ? 'Yes' : 'No' }}</span>
                                                        {{-- <a href="{{ route('customer-managers.create', $customer->id) }}" class="btn btn-success btn-sm ms-3">Add Manager</a> --}}
                                                    </td>

                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <!-- Manager Details -->
                                    @if($customer->have_manager && $customer->managers->isNotEmpty())
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title">Manager Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-striped">
                                                    @foreach($customer->managers as $manager)
                                                        <tr>
                                                            <th>Manager Name</th>
                                                            <td>{{ $manager->fname ?? 'NA' }} {{ $manager->lname ?? 'NA' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Manager Mobile</th>
                                                            <td>{{ $manager->mobile ?? 'NA' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Manager WhatsApp</th>
                                                            <td>{{ $manager->whatsapp ?? 'NA' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Manager Email</th>
                                                            <td>{{ $manager->email ?? 'NA' }}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th>Manager Position</th>
                                                            <td>{{ $manager->relation ?? 'NA' }}</td>
                                                        </tr> --}}
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="text-end">
                                                                    <!-- Button to edit the manager -->
                                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editManagerModal{{ $manager->id }}">
                                                                        Edit Manager
                                                                    </button>
                                                                    <!-- Form to delete the manager -->
                                                                    <form action="{{ route('customer-managers.destroy', ['customerId' => $customer->id, 'managerId' => $manager->id]) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this manager?');">
                                                                            Delete Manager
                                                                        </button>
                                                                    </form>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card mb-4">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">No Manager Assigned</h5>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addManagerModal">Add Manager</button>
                                            </div>

                                            <div class="card-body">
                                                <p>No managers have been assigned to this customer.</p>
                                            </div>
                                        </div>
                                    @endif



                                    @if($customer->have_company && $customer->company)
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title">Company Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-striped">
                                                    {{-- @foreach($customer->company as $company) --}}
                                                        <tr>
                                                            <th>Company Name</th>
                                                            <td>{{ $customer->company->name ?? 'NA' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Company Mobile</th>
                                                            <td>{{ $customer->company->mobile ?? 'NA' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>GST Number</th>
                                                            <td>{{ $customer->company->gst ?? 'NA' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <td>{{ $customer->company->address ?? 'NA' }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="text-end">
                                                                    <!-- Button to edit the manager -->
                                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCompanyModal">
                                                                        Edit Company
                                                                    </button>
                                                                    <!-- Form to delete the manager -->
                                                                    <form action="{{ route('company.destroy', $customer->company->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this company?');">Delete Company</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    {{-- @endforeach --}}
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card mb-4">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">No Company Assigned</h5>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Add Company</button>
                                            </div>

                                            <div class="card-body">
                                                <p>No company is assigned to this customer.</p>
                                            </div>
                                        </div>
                                    @endif

                                </div>
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

            <!-- Edit manager Modal -->
            @foreach($customer->managers as $manager)

                <div class="modal fade" id="editManagerModal{{ $manager->id }}" tabindex="-1" aria-labelledby="editManagerModalLabel{{ $manager->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editManagerModalLabel{{ $manager->id }}">Manager Information</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('customer-managers.update', $manager->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Manager Information Form Fields -->
                                        <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                        <div class="mb-3 col-6">
                                            <label for="fname{{ $manager->id }}" class="form-label">First Name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="fname{{ $manager->id }}" name="manager_fname" value="{{ $manager->fname }}" required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="lname{{ $manager->id }}" class="form-label">Last Name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="lname{{ $manager->id }}" name="manager_lname" value="{{ $manager->lname }}" required>
                                        </div>
                                        <div class="mb-3 col-6">
                                        <label for="manager_gender{{ $manager->id }}" class="form-label">
                                            Gender <span class="text-danger"><sup>*</sup></span>
                                        </label>
                                        <select class="form-control" id="manager_gender{{ $manager->id }}" name="manager_gender" required>
                                            <option value="" disabled>Select Gender</option>
                                            <option value="Male" @if($manager->gender == "Male") selected @endif>Male</option>
                                            <option value="Female" @if($manager->gender == "Female") selected @endif>Female</option>
                                            <option value="Other" @if($manager->gender == "Other") selected @endif>Other</option>
                                        </select>
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label for="manager_mobile{{ $manager->id }}" class="form-label">Mobile <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="manager_mobile{{ $manager->id }}" name="manager_mobile" value="{{ $manager->mobile }}" required>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="manager_whatsapp{{ $manager->id }}" class="form-label">WhatsApp <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="manager_whatsapp{{ $manager->id }}" name="manager_whatsapp" value="{{ $manager->whatsapp }}">
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="manager_email{{ $manager->id }}" class="form-label">Email <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="email" class="form-control" id="manager_email{{ $manager->id }}" name="manager_email" value="{{ $manager->email }}" required>
                                        </div>

                                        {{-- <div class="mb-3 col-6">
                                            <label for="manager_position{{ $manager->id }}" class="form-label">Position</label>
                                            <input type="text" class="form-control" id="manager_position{{ $manager->id }}" name="manager_position" value="{{ $manager->relation }}" required>
                                            <small class="form-text text-muted">e.g., PA, Manager, Admin, etc.</small>
                                        </div> --}}
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach


            <!-- Edit Company Modal -->
            @if ($customer->have_company && $customer->company)
                <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCompanyModalLabel">Edit Company Information</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('company.update', $customer->company->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <!-- Manager Information Form Fields -->
                                        <div class="mb-3 col-12">
                                            <label for="" class="form-label">Company Name <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $customer->company->name }}" required>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="mobile" class="form-label">Mobile <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $customer->company->mobile }}" required>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="gst" class="form-label">GST Number <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="gst" name="gst" value="{{ $customer->company->gst }}" required>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="address" class="form-label">Address <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ $customer->company->address }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Modal for Adding Manager -->
            <div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addManagerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addManagerModalLabel">Add Manager</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('customer-managers.store') }}" method="POST" onsubmit="return validateForm()">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="mb-3">
                        <label for="manager_fname" class="form-label">First Name <span class="text-danger"><sup>*</sup></span> </label>
                        <input type="text" class="form-control" id="manager_fname" name="manager_fname" required minlength="2" maxlength="50" autofocus>
                        </div>
                        <div class="mb-3">
                        <label for="manager_lname" class="form-label">Last Name <span class="text-danger"><sup>*</sup></span> </label>
                        <input type="text" class="form-control" id="manager_lname" name="manager_lname" required minlength="2" maxlength="50">
                        </div>
                        <div class="mb-3">
                        <label for="manager_mobile" class="form-label">Mobile <span class="text-danger"><sup>*</sup></span> </label>
                        <input type="number" class="form-control" id="manager_mobile" name="manager_mobile" min="0" required pattern="^\d{10}$">
                        </div>
                        <div class="mb-3">
                            <label for="manager_gender" class="form-label">Gender <span class="text-danger"><sup>*</sup></span> </label>
                            <select class="form-control" id="manager_gender" name="manager_gender" required>
                                <option value="" disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="manager_whatsapp" class="form-label">Whatsapp <span class="text-danger"><sup>*</sup></span> </label>
                            <input type="number" class="form-control" id="manager_whatsapp" name="manager_whatsapp" min="0" required pattern="^\d{10}$">
                            </div>
                        <div class="mb-3">
                        <label for="manager_email" class="form-label">Email <span class="text-danger"><sup>*</sup></span> </label>
                        <input type="email" class="form-control" id="manager_email" name="manager_email" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="manager_position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="manager_position" name="manager_position">
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Add Manager</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>


            <!-- Modal for Adding Company -->
            <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addCompanyModalLabel">Add Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('company.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name <span class="text-danger"><sup>*</sup></span></label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="mb-3">
                        <label for="company_mobile" class="form-label">Company Mobile <span class="text-danger"><sup>*</sup></span></label>
                        <input type="text" class="form-control" id="company_mobile" name="company_mobile" required>
                        </div>
                        <div class="mb-3">
                        <label for="company_gst" class="form-label">GST Number <span class="text-danger"><sup>*</sup></span></label>
                        <input type="text" class="form-control" id="company_gst" name="company_gst">
                        </div>
                        <div class="mb-3">
                        <label for="company_address" class="form-label">Address <span class="text-danger"><sup>*</sup></span</label>
                        <textarea class="form-control" id="company_address" name="company_address"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Company</button>
                    </form>
                    </div>
                </div>
                </div>
            </div>







@endsection
