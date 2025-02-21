@extends('layout.app')
@section('title', 'Lead Management')
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
                        <h3 class=" font-weight-bold text-primary">Suppliers List</h3>
                    </div>
                    <div class="text-right p-2">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal"> Add Supplier</button>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            {{-- <div class="text-right mb-3">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createSourceModal">Create source</button>
                              </div> --}}

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                    <thead class="bg-light text-dark">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            {{-- <th>Contact</th>
                                            <th>Contact person</th>
                                            <th>Address</th>--}}
                                            <th>Services</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                {{-- <td>{{ $supplier->contact }}</td>
                                                <td>{{ $supplier->contact_person }}</td>
                                                <td>{{ $supplier->address }}</td>--}}
                                                <td>
                                                    @if($supplier->services->isNotEmpty())
                                                        {{ $supplier->services->pluck('name')->implode(', ') }}
                                                    @else
                                                        No services available
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="text-info border-0 bg-transparent dropdown-toggle"
                                                                type="button" id="dropdownMenuButton{{ $supplier->id }}"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="dropdownMenuButton{{ $supplier->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-success view-supplier-btn"
                                                                       href="javascript:void(0);"
                                                                       data-name="{{ $supplier->name }}"
                                                                       data-gstin="{{ $supplier->gstin }}"
                                                                       data-email="{{ $supplier->email }}"
                                                                       data-contact="{{ $supplier->contact }}"
                                                                       data-contact_person="{{ $supplier->contact_person }}"
                                                                       data-services="{{ $supplier->services->pluck('name')->implode(', ') }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-primary edit-supplier-btn" href="#" data-id="{{ $supplier->id }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this supplier?');">
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


                            <!-- Create Suppliers Modal Structure -->
                            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="createModalLabel">Add Supplier</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <!-- Form content here -->
                                    <form action="{{ route('suppliers.store') }}" method="POST">
                                        {{-- <form  method="POST"> --}}
                                        @csrf
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label">Name <span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter supplier name" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="services" class="col-md-4 col-form-label">Services <span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <!-- Updated Select with multiple attribute -->
                                                <select name="services[]" id="services" class="form-control" multiple="multiple" required>
                                                    <option value="">Select service(s)</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="gstin" class="col-md-4 col-form-label">GST No.</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="gstin" name="gstin" placeholder="Enter GST no">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="contact" class="col-md-4 col-form-label">Contact </label>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control" id="contact" name="contact" min="0" placeholder="Contact No">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label">Email</label>
                                            <div class="col-md-8">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="contact_person" class="col-md-4 col-form-label">Contact Person</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person name">
                                            </div>
                                        </div>



                                        {{-- <div class="form-group row">
                                            <label for="address" class="col-md-4 col-form-label">Address</label>
                                            <div class="col-md-8">
                                                <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-md-4 col-form-label">Description</label>
                                            <div class="col-md-8">
                                                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                                            </div>
                                        </div> --}}

                                        <!-- Button Group -->
                                        <div class="form-group row">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>

                                </div>
                                </div>
                            </div>

                <!-- Edit Supplier Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            <form id="editSourceForm" action="{{ route('suppliers.update') }}" method="POST">
                                @csrf
                                <input type="hidden" id="supplierId" name="id">
                                <div class="form-group row">
                                    <label for="editName" class="col-md-4 col-form-label">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="editName" name="editName" placeholder="Enter supplier name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="editServices" class="col-md-4 col-form-label">Services<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select id="editServices" name="services[]" class="form-control" multiple required>
                                            <option value="">Select service(s)</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="editgstin" class="col-md-4 col-form-label">GST No.</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="editgstin" name="editgstin" placeholder="Enter GST no">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="editcontact" class="col-md-4 col-form-label">Contact </label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" id="editcontact" name="editcontact" min="0" placeholder="Contact No">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="editemail" class="col-md-4 col-form-label">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" id="editemail" name="editemail" placeholder="Enter email">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="editcontact_person" class="col-md-4 col-form-label">Contact Person</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="editcontact_person" name="editcontact_person" placeholder="Enter contact person name">
                                    </div>
                                </div>

                                <!-- Button Group -->
                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View Modal -->
                <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewModalLabel">Supplier Details</h6>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td id="modalName"></td>
                                        </tr>
                                        <tr>
                                            <th>Services</th>
                                            <td id="modalServices"></td>
                                        </tr>
                                        <tr>
                                            <th>GST Number</th>
                                            <td id="modalGSTNumber"></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td id="modalEmail"></td>
                                        </tr>
                                        <tr>
                                            <th>Contact</th>
                                            <td id="modalContact"></td>
                                        </tr>
                                        <tr>
                                            <th>Contact Person</th>
                                            <td id="modalContactPerson"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


<script>
    $(document).ready(function() {
        $('.edit-supplier-btn').on('click', function(e) {
            e.preventDefault();
            var supplierId = $(this).data('id');
            // console.log(supplierId);return;
            $.ajax({
                url: '{{ route('suppliers.edit', ':id') }}'.replace(':id', supplierId),
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#editName').val(response.supplier.name);
                    $('#editgstin').val(response.supplier.gstin);
                    $('#editemail').val(response.supplier.email);
                    $('#editcontact').val(response.supplier.contact);
                    $('#editcontact_person').val(response.supplier.contact_person);
                    $('#supplierId').val(response.supplier.id);

                   // Clear previous selections
                    $('#editServices').val([]);

                    // Set selected services
                    var selectedServices = response.supplier.services.map(service => service.id);
                    $('#editServices').val(selectedServices);

                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });


    });
    // Script for Add Modal
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#createModal form');
        const name = document.getElementById('name');
        const gstin = document.getElementById('gstin');
        const contact = document.getElementById('contact');
        const email = document.getElementById('email');
        const contactPerson = document.getElementById('contact_person');
        const services = document.getElementById('services');


        form.addEventListener('submit', function (event) {
            let valid = true;
            console.log("create submitted")

            clearErrors();

            if (name.value.trim() === '') {
                showError(name, 'Supplier Name is required');
                valid = false;
            }

            if (services.selectedOptions.length === 0) {
                showError(services, 'At least one service must be selected');
                valid = false;
            }

            // if (gstin.value.trim() === '') {
            //     showError(gstin, 'GST No is required');
            //     valid = false;
            // }

            // if (contactPerson.value.trim() === '') {
            //     showError(contactPerson, 'Contact person name is required');
            //     valid = false;
            // }

            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            const emailID = email.value.trim();
            if (emailID && !emailPattern.test(emailID)) {
                showError(email, 'Valid Email is required');
                valid = false;
            }


            const mobileValue = contact.value.trim();
            if (mobileValue && (mobileValue.length !== 10 || !/^\d{10}$/.test(mobileValue))) {
                showError(contact, 'Mobile Number must be exactly 10 digits long');
                valid = false;
            }

            console.log(valid)

            if (!valid) {
                event.preventDefault();
            }

        });

        function showError(input, message) {
            const errorElement = document.createElement('div');
            errorElement.className = 'text-danger';
            errorElement.textContent = message;
            input.closest('.col-md-8').appendChild(errorElement);
        }

        function clearErrors() {
            const errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(function (element) {
                element.remove();
            });
        }
    });

    // Script for View Modal
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-supplier-btn');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log("test");
                // Populate the modal with the supplier data
                document.getElementById('modalName').textContent = this.getAttribute('data-name');
                document.getElementById('modalGSTNumber').textContent = this.getAttribute('data-gstin')|| '--';
                document.getElementById('modalEmail').textContent = this.getAttribute('data-email')|| '--';
                document.getElementById('modalContact').textContent = this.getAttribute('data-contact')|| '--';
                document.getElementById('modalContactPerson').textContent = this.getAttribute('data-contact_person')|| '--';
                document.getElementById('modalServices').textContent = this.getAttribute('data-services')||'No services available';

                // Show the modal
                const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
                viewModal.show();
            });
        });
    });

</script>




<script>
    $(document).ready(function() {
        // Apply Select2 on the services and edit services dropdown
        $('#services').select2({
            placeholder: 'Select service(s)',
            allowClear: true,
            width: '100%'
        });

        $('#editServices').select2({
            placeholder: 'Select service(s)',
            allowClear: true,
            width: '100%'
        });
    });
</script>




@endsection
