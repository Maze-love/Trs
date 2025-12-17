@extends('layout')
@section('content')

<x-sidebar></x-sidebar>

<x-column class="container tops">
    {{-- <x-alert class="mssg alert-success"></x-alert> --}}
    <div class="my-3">
        <button
            class="btn btn-primary toggle-modal-btn"
            data-bs-target="#addPlaceModal"
            data-bs-toggle="modal"
        >
            Add New Destinations
        </button>
    </div>

    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Destination</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="destination-table-body">
            @if ($places->count()==0)
                <tr id="no-destinations-row">

                    <td colspan="3">no data</td>
                </tr>
            @endif
            @foreach ($places as $place)
                <tr id="destination-row-{{ $place->id }}">
                    <td>{{$place->title}}</td>
                    <td>
                        <img src="{{$place->image->first() ? asset('storage/'.$place->image->first()->path) : asset('/images/blog-1.jpg')}}" class="table-img" alt="">
                    </td>
                    <td>
                        <button
                            class="btn btn-sm btn-warning btn-edit-destination"
                            data-bs-target="#editPlaceModal"
                            data-bs-toggle="modal"
                            data-id="{{ $place->id }}"
                        >Edit</button>
                    <button class="btn btn-sm btn-danger btn-delete-destination" data-id="{{ $place->id }}">Delete</button>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    <!-- Add places modal -->
    <div class="modal fade" id="addPlaceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="mb-1">Add New Place</h2>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body">
                    <form action="/place/post" id="addPlacesForm" class="row g-3 p-3 bg-light rounded" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- place-title -->
                        <div class="mb-3">
                            <label for="addDestinationTitle" class="form-label">Destination Place</label>
                            <input type="text" class="form-control" id="addPlaceTitle" name="title" placeholder="Enter Destination Place"/>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="addImage" class="form-label">Place Image</label>
                            <input type="file" class="upload form-control" name="logo[]" multiple/>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-sm btn-success add-room-btn" type="submit">
                                + Add Places
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit places modal -->
    <div class="modal fade" id="editPlaceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="mb-1">Edit Place</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPlaceForm" class="row g-3 p-3 bg-light rounded" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit-place-id" name="place_id">
                        
                        <!-- place-title -->
                        <div class="mb-3">
                            <label for="editPlaceTitle" class="form-label">Destination Place</label>
                            <input type="text" class="form-control" id="editPlaceTitle" name="title" placeholder="Enter Destination Place"/>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="editImage" class="form-label">New Place Image (Optional)</label>
                            <p class="small text-muted">Uploading new images will replace all existing ones.</p>
                            <input type="file" class="upload form-control" name="logo[]" multiple/>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-sm btn-success" type="submit">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-column>

<script>
    $(document).ready(function() {

        // Hide message alert initially
        $(".mssg").addClass("d-none");

        /**
         * Adds a new destination row to the table.
         * @param {object} destination - The destination object from the server.
         */
        function addDestinationToTable(destination) {
            const tableBody = document.getElementById('destination-table-body');
            const noDataRow = document.getElementById('no-destinations-row');

            if (noDataRow) {
                noDataRow.remove();
            }

            const imageUrl = destination.image && destination.image.length > 0
                ? `{{ asset('storage') }}/${destination.image[0].path}`
                : `{{ asset('/images/blog-1.jpg') }}`;

            const newRow = document.createElement('tr');
            newRow.id = `destination-row-${destination.id}`;
            newRow.innerHTML = `
                <td>${destination.title}</td>
                <td>
                    <img src="${imageUrl}" class="table-img" alt="">
                </td>
                <td>
                      <button class="btn btn-sm btn-warning btn-edit-destination" data-bs-target="#editPlaceModal"  data-bs-toggle="modal" data-id=${destination.id}">Edit
                     </button>
                    <button class="btn btn-sm btn-danger btn-delete-destination" data-id="${destination.id}" >Delete</button>
                </td>
            `;
            tableBody.prepend(newRow);
        }

        /**
         * Adds a "no data" row to the table if it becomes empty.
         */
        function addNoDestinationsRow() {
            const tableBody = document.getElementById('destination-table-body');
            if (tableBody.children.length === 0) {
                const row = document.createElement('tr');
                row.id = 'no-destinations-row';
                row.innerHTML = `<td colspan="3" class="text-center">No destinations found.</td>`;
                tableBody.appendChild(row);
            }
        }

        // Handle the AJAX form submission
        $(document).on('submit', '#addPlacesForm', function(e){
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            let url = form.attr('action');

            // Clear previous validation errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",

                success: function(response) {
                    if (response.success) {
                        // Hide the modal
                        $('#addPlaceModal').modal('hide');
                        // Reset the form
                        form[0].reset();

                        // Show a success message
                        $(".mssg").removeClass("d-none").html(response.message);

                        // Add the new destination to the table
                        addDestinationToTable(response.destination);
                    }
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        // Display validation errors
                        if (errors.title) {
                            $('#addPlaceTitle').addClass('is-invalid').next('.invalid-feedback').text(errors.title[0]);
                        }
                        if (errors['logo.0']) { // For file array validation
                            //  $('input[name="logo[]"]').addClass('is-invalid').next('.invalid-feedback').text(errors['logo.0'][0]);
                        }
                    } else {
                        // Handle other errors
                        alert("An unexpected error occurred.");
                        console.error(xhr.responseText);
                    }
                }
            });
        });

        //.. logic for deleting destination
        $('#destination-table-body').on('click', '.btn-delete-destination', function () {
            const destinationId = $(this).data('id');
            const url = `/place/delete/${destinationId}`;

            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, send the AJAX request
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                // Show success message
                                Swal.fire(
                                    'Deleted!',
                                    'Destination has been deleted.',
                                    'success'
                                );
                                // Show success toast
                                // Find the row and remove it with a fade-out effect
                                $('#destination-row-' + destinationId).fadeOut('slow', function() {
                                    $(this).remove();
                                    // After removing, check if the table is empty
                                    addNoDestinationsRow();
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            let response = xhr.responseJSON;
                            Swal.fire(
                                'Error!',
                                'Could not delete destination.'+response,
                                'error'
                            )
                        }
                    });
                }
            })
        });

        // --------------------------------------------------------------
        //  UPDATE LOGIC
        // --------------------------------------------------------------

        // 1. Open the Edit modal and fetch data
        $('#destination-table-body').on('click', '.btn-edit-destination', function () {
            const destinationId = $(this).data('id');
            
            $.ajax({
                type: "GET",
                url: `/place/${destinationId}/edit`,
                dataType: "json",
                success: function (destination) {
                    $('#editPlaceModal').find('#edit-place-id').val(destination.id);
                    $('#editPlaceModal').find('#editPlaceTitle').val(destination.title);
                    $('#editPlaceModal').modal('show');
                },
                error: function (xhr) {
                    alert("Could not load destination data.");
                    console.error(xhr.responseText);
                }
            });
        });

        // 2. Submit the edit form
        $('#editPlaceForm').on('submit', function (e) {
            e.preventDefault();

            const destinationId = $('#edit-place-id').val();
            const url = `/place/update/${destinationId}`;
            let formData = new FormData(this);
            formData.append('_method', 'POST'); // Simulate PUT/PATCH for file uploads

            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        const updatedDestination = response.destination;
                        const row = document.getElementById(`destination-row-${updatedDestination.id}`);

                        const imageUrl = updatedDestination.image && updatedDestination.image.length > 0
                            ? `{{ asset('storage') }}/${updatedDestination.image[0].path}`
                            : `{{ asset('/images/blog-1.jpg') }}`;

                        row.innerHTML = `
                            <td>${updatedDestination.title}</td>
                            <td><img src="${imageUrl}" class="table-img" alt=""></td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit-destination" data-bs-target="#editPlaceModal" data-bs-toggle="modal" data-id="${updatedDestination.id}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete-destination" data-id="${updatedDestination.id}">Delete</button>
                            </td>
                        `;
                        
                        $('#editPlaceModal').modal('hide');
                        Swal.fire('Updated!', 'Destination has been updated.', 'success');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.title) {
                            $('#editPlaceTitle').addClass('is-invalid').next('.invalid-feedback').text(errors.title[0]);
                        }
                    } else {
                        alert("An unexpected error occurred.");
                    }
                }
            });
        });
    });
</script>
@endsection