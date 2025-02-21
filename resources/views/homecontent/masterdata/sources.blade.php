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
                        <h3 class=" font-weight-bold text-primary">Sources List</h3>
                    </div>
                    {{-- <div class="text-right p-2">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createSourceModal"> Create source</button>
                    </div> --}}
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="text-right mb-3">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createSourceModal">Create source</button>
                              </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" cellspacing="0">
                                    <thead class="bg-light text-dark">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Added by</th>
                                            <th>Updated by</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sources as $source)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $source->title }}</td>
                                                <td>{{ $source->description }}</td>
                                                <td>
                                                    @if ($source->addedBy)
                                                        {{ $source->addedBy->first_name ?? 'N/A' }}
                                                        {{ $source->addedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($source->updatedBy)
                                                        {{ $source->updatedBy->first_name ?? 'N/A' }}
                                                        {{ $source->updatedBy->last_name ?? 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <div class="text-center">
                                                        <!-- View Button -->
                                                        <a class="btn btn-sm btn-success" href="#" data-bs-toggle="modal" data-bs-target="#viewModal{{ $card->id }}">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </a>

                                                        <!-- Edit Button -->
                                                            <a class="btn btn-sm btn-primary edit-source-btn" href="#" data-id="{{ $source->id }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>

                                                        <!-- Delete Button -->
                                                        <form action="{{ route('sources.destroy', $source->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this card?');">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td> --}}
                                                <td>
                                                    <div class="text-center">
                                                        <!-- Dropdown button -->
                                                        <div class="dropdown">
                                                            <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton{{ $source->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $source->id }}">
                                                                {{-- <li>
                                                                    <a class="dropdown-item text-success" href="">
                                                                        <i class="fa-solid fa-eye"></i> View
                                                                    </a>
                                                                </li> --}}
                                                                <li>
                                                                    <a class="dropdown-item text-primary edit-source-btn" href="#" data-id="{{ $source->id }}">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('sources.destroy', $source->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this source?');">
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

            <!-- Modal Structure -->
            <div class="modal fade" id="createSourceModal" tabindex="-1" role="dialog" aria-labelledby="createSourceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="createSourceModalLabel">Create Source</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <!-- Form content here -->
                    <form action="{{ route('sources.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="sourceName" class="col-md-4 col-form-label">Source Name <span class="text-danger">*</span></label>

                            <div class="col-md-8">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter source name" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label">Description</label>
                            <div class="col-md-8">
                                <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

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

            <!-- Edit Source Modal -->
            <div class="modal fade" id="editSourceModal" tabindex="-1" role="dialog" aria-labelledby="editSourceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="editSourceModalLabel">Edit Source</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <form id="editSourceForm" action="{{ route('sources.update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="sourceId" name="id">
                            <div class="form-group row">
                                <label for="editTitle" class="col-md-4 col-form-label">Source Name <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="editTitle" name="title" placeholder="Enter source name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="editDescription" class="col-md-4 col-form-label">Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="editDescription" name="description" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('shared.footer')
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<script>
    $(document).ready(function() {
        $('.edit-source-btn').on('click', function(e) {
            e.preventDefault();
            var sourceId = $(this).data('id');
            $.ajax({
                url: '/sources/edit/' + sourceId,
                method: 'GET',
                // data: {
                //     _token: '{{ csrf_token() }}'
                // },
                success: function(response) {
                    $('#editTitle').val(response.title);
                    $('#editDescription').val(response.description);
                    $('#sourceId').val(response.id);

                    $('#editSourceModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        });



    $('#editSourceModal .close').on('click', function() {
        $('#editSourceModal').modal('hide');
    });


    $('#editSourceModal .btn-secondary').on('click', function() {
        $('#editSourceModal').modal('hide');
    });

    });
</script>


@endsection
