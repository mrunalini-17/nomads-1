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
                        <h3 class=" font-weight-bold text-primary">Card List</h3>
                    </div>



                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="text-right p-2">
                                {{-- <a href="{{route('cards.create')}}" class="btn btn-primary btn-sm">Add Card</a> --}}
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCardModal"> Add Card</button>
                            </div>
                            <div class="table-responsive">

                                <table class="table " id="dataTable" cellspacing="0">
                                       <thead class="bg-light text-dark">
                                        <tr>
                                            <th>Sr no</th>
                                            <th>Card Name</th>
                                            <th>Card Number</th>
                                            <th>Expiry Date</th>
                                            <th>Description</th>
                                            <th>Added by</th>
                                            <th>Updated by</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cards as $card)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $card->card_name }}</td>
                                                <td>{{ $card->card_number }}</td>
                                                <td>{{ $card->expiry_date }}</td>
                                                <td>{{ $card->description ?: '--' }}</td>
                                                <td>
                                                    @if ($card->addedBy)
                                                        {{ $card->addedBy->first_name ?? 'N/A' }}
                                                        {{ $card->addedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($card->updatedBy)
                                                        {{ $card->updatedBy->first_name ?? 'N/A' }}
                                                        {{ $card->updatedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                {{--<td>
                                                    <div class="text-center">
                                                        <!-- View Button -->
                                                        <a class="text-success mx-1" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $card->id }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </a>

                                                        <!-- Edit Button -->
                                                        <a class="text-primary mx-1" href="{{ route('cards.edit', $card->id) }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="text-danger border-0 bg-transparent p-0 mx-1"
                                                                onclick="return confirm('Are you sure you want to delete this card?');">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>--}}
                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $card->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $card->id }}">
                                                                <li>
                                                                    <a class="dropdown-item text-success view-card-btn"
                                                                       href="javascript:void(0);"
                                                                       data-card-name="{{ $card->card_name }}"
                                                                       data-card-number="{{ $card->card_number }}"
                                                                       data-expiry-date="{{ $card->expiry_date }}"
                                                                       data-description="{{ $card->description }}">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    {{-- <a class="dropdown-item text-primary" href="{{ route('cards.edit', $card->id) }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a> --}}

                                                                    <button class="dropdown-item text-primary edit-card-btn"
                                                                            data-card='@json($card)'>
                                                                        <i class="fa-solid fa-edit"></i> Edit
                                                                    </button>

                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this card?');">
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

    <!-- View Card Modal -->
    <div class="modal fade" id="viewCardModal" tabindex="-1" aria-labelledby="viewCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="viewCardModalLabel">Card Details</h5> --}}
                    <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewCardModalLabel">Card Details</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Card Name</th>
                                <td id="modalCardName"></td>
                            </tr>
                            <tr>
                                <th>Card Number</th>
                                <td id="modalCardNumber"></td>
                            </tr>
                            <tr>
                                <th>Expiry Date</th>
                                <td id="modalExpiryDate"></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td id="modalDescription"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Card Modal -->
    <div class="modal fade" id="editCardModal" tabindex="-1" aria-labelledby="editCardModalLabel" aria-hidden="true">>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0 font-weight-bold text-primary" id="viewCardModalLabel">Edit Card</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="editCardForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="edit_card_name" class="form-label">Card Name</label>
                                <input type="text" class="form-control" id="edit_card_name" name="card_name" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="edit_card_number" class="form-label">Card Number</label>
                                <input type="number" class="form-control" id="edit_card_number" name="card_number" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="edit_expiry_date" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="edit_expiry_date" name="expiry_date" required>
                                <small class="text-muted">e.g. Aug 2026, Jun 2028</small>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="edit_description" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description" name="description"></textarea>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all view buttons
            const viewButtons = document.querySelectorAll('.view-card-btn');

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the card data from data attributes
                    const cardName = this.getAttribute('data-card-name');
                    const cardNumber = this.getAttribute('data-card-number');
                    const expiryDate = this.getAttribute('data-expiry-date');
                    const description = this.getAttribute('data-description') || '--';

                    // Populate the modal with the card data
                    document.getElementById('modalCardName').textContent = cardName;
                    document.getElementById('modalCardNumber').textContent = cardNumber;
                    document.getElementById('modalExpiryDate').textContent = expiryDate;
                    document.getElementById('modalDescription').textContent = description;

                    // Show the modal
                    const viewCardModal = new bootstrap.Modal(document.getElementById('viewCardModal'));
                    viewCardModal.show();
                });
            });


            // Edit modal handle
            const editModal = document.getElementById('editCardModal');
            const cardNameInput = document.getElementById('edit_card_name');
            const cardNumberInput = document.getElementById('edit_card_number');
            const expiryDateInput = document.getElementById('edit_expiry_date');
            const descriptionInput = document.getElementById('edit_description');
            const editForm = document.getElementById('editCardForm');

            document.querySelectorAll('.edit-card-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const card = JSON.parse(this.getAttribute('data-card'));

                    // Fill the modal with the card data
                    cardNameInput.value = card.card_name;
                    cardNumberInput.value = card.card_number;
                    expiryDateInput.value = card.expiry_date;
                    descriptionInput.value = card.description || '';

                    // Update form action to the correct route
                    editForm.action = `/cards/${card.id}/update`;

                    // Show the modal
                    new bootstrap.Modal(editModal).show();
                });
            });
        });
    </script>




@endsection
