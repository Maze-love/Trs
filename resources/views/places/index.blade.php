@extends('layout')
@section('content')

<x-sidebar></x-sidebar>

<!-- Add Category -->
  

 <x-column class="container tops">

        <div class="my-3">
              <button
                  class="btn btn-secondary toggle-modal-btn"
                  data-bs-target="#addCategoryModal"
                  data-bs-toggle="modal"
              >
                  Add New Category
              </button>            
        </div> 

      <table class="table table-striped table-hover ">
                  <thead>
                          <tr>
                              <th>Category</th>
                                                        
                          </tr>
                  </thead>

                  <tbody id="category-table-body">
                      @if ($categories->count()==0)
                          <tr>           
                              <td>no data</td>
                          </tr>
                      @endif
                      @foreach ($categories as $category)
                          <tr id="category-row-{{ $category->id }}">
                                <td>{{$category->name}}</td>
                              
                              <td>
                                  {{-- <a class="btn btn-sm btn-warning" href="/edit/place/{{$category->id}}">Edit</a> --}}
                                  <button
                                      class="btn btn-sm btn-warning"
                                      data-bs-target="#editCategoryModal"
                                      data-bs-toggle="modal"
                                      class="toggle-modal-btn"
                                      data-id="{{ $category->id }}"
                                  >
                                      Edit
                                  </button>  
                                      
                                  <button class="btn btn-sm btn-danger btn-delete-category" data-id="{{ $category->id }}">Delete</button>
                              </td>
                          </tr>
                          
                      @endforeach
                      
                      
                  
                  </tbody>
      </table>
      

    
        <!-- Add Category modal -->
        <div class="modal fade" id="addCategoryModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h2 class="mb-1">Add New Category</h2>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>

                <div class="modal-body">
                  <form
                    action="/category/post"
                    id="addCategoryForm"
                    class="row g-3 p-3 bg-light rounded"
                    method="POST"
                    enctype="multipart/form-data"
                  >
                    @csrf
                    <div class="col-12">
                      <label for="addCategoryTitle" class="form-label"
                        >Category</label
                      >
                      <input
                        type="text"
                        class="form-control {{$errors->has('name') ? 'is-invalid':'' }}"
                        id="addCategoryTitle"
                        name="name"
                        placeholder="Create Category.."
                        value="{{old('name')}}"
                      />
                    </div>

                    <div class="col-12">
                      <button
                        type="submit"
                        class="btn btn-sm btn-primary add-room-btn"
                      >
                        + Add Category
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
    
        <!-- Update Category modal -->
        <div class="modal fade" id="editCategoryModal">
          <div class="modal-dialog">
              <form id="editCategoryForm">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Edit Category</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                          <input type="hidden" id="edit-category-id" name="catgory_id">
                          @csrf

                          <div class="mb-3">
                              <label for="edit-category-name" class="form-label">Category Name</label>
                              <input type="text" class="form-control" name="name" id="edit-category-name" >
                          </div>
                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                  </div>
              </form>
          </div>
        </div>

 </x-column>

<script>

  /**
   * Adds a new category row to the table.
   * @param {object} category - The category object from the server.
   */
    $(".mssg").addClass("d-none");

    function addCategoryToTable(category) {
        const tableBody = document.getElementById('category-table-body');
        
      
        // 2. Create the new table row element
        const newRow = document.createElement('tr');
        newRow.id = `category-row-${category.id}`;


        // 4. Populate the inner HTML of the row with data
        newRow.innerHTML = `
            <td>${category.name}</td>
            <td>
                
                <button class="btn btn-sm toggle-modal-btn btn-warning" data-bs-target="#editCategoryModal" data-bs-toggle="modal" data-id="${category.id}">
                Edit</button>  
                <button class="btn btn-sm btn-danger btn-delete-category" data-id="${category.id}">Delete</button>

            </td>
        `;

        // 5. Add the new row to the top of the table body
        tableBody.prepend(newRow); // 'prepend' adds it as the first child
    }


    $('#addCategoryForm').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');

        $('.form-control').removeClass('is-invalid');

        $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          dataType: "json",

          // --- UPDATED SUCCESS CALLBACK ---
          success: function (response) {
            console.log(response);
            
            if(response.success){
                // Hide the modal
                $('#addCategoryModal').modal('hide');

                // Reset the form
                form[0].reset();

                // Show a success toast notification instead of an alert
                $(".mssg").removeClass("d-none");

                $(".mssg").html("category added successfully");
                console.log(response.category);
                
                // Call the function to add the new category to our table
                addCategoryToTable(response.category);
            }
            
          },

          error: function (xhr, status, error) {
            // ... (error handling remains the same)
            let response = xhr.responseJSON;
            if (xhr.status === 422) {
              if (response.errors.name) {
                $('#addCategoryTitle').addClass('is-invalid');
                $('#addCategoryNameError').text(response.errors.name[0]);
              }
            } else {
              alert("Error occurred"); 
              //showToast(response.message || 'An error occurred.', 'error');
            }
          },

        });
    });


    //.. logic for deleting categories
    $('#category-table-body').on('click', '.btn-delete-category', function () {
        const categoryId = $(this).data('id');
        const url = `/categories/${categoryId}`;


        // Helper function to add the "No categories" placeholder row
        function addNoCategoriesRow() {
            const tableBody = document.getElementById('category-table-body');
            if (tableBody.children.length === 0) {
                const row = `
                    <tr id="no-categories-row">
                        <td colspan="4" class="text-center">No categories found.</td>
                    </tr>
                `;
                tableBody.innerHTML = row;
            }
        }


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
                            // Show success toast
                            // Find the row and remove it with a fade-out effect
                            $('#category-row-' + categoryId).fadeOut('slow', function() {
                                $(this).remove();
                                // After removing, check if the table is empty

                                addNoCategoriesRow();
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        let response = xhr.responseJSON;
                        alert('Could not delete category.'+response);
                    }
                });
            }
          })
    });      
   
    // --------------------------------------------------------------
    //  NEW: UPDATE LOGIC
    // --------------------------------------------------------------
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // -----------------------------------------------------------------
    //  Opens the Edit modal when the “Edit” button is clicked
    // -----------------------------------------------------------------
    $('#category-table-body').on('click', '.btn-warning', function () {
        const categoryId = $(this).data('id');
        console.log(categoryId);
        
        // Fetch the current category data (you can also embed it in data-attributes)
        $.ajax({
            type: "GET",
            url: `/categories/${categoryId}/edit`,
            dataType: "json",
            success: function (category) {
                // Populate the modal fields
                $('#editCategoryModal').find('#edit-category-id').val(category.id);
                $('#editCategoryModal').find('#edit-category-name').val(category.name);
                
                // Show the modal
                $('#editCategoryModal').modal('show');
            },
            error: function (xhr, status, error) {
                // showToast('Could not load category data.', 'error');
                alert("Could not load category data");
            }
        });
    });

    // -----------------------------------------------------------------
    //  Submit the edit form (AJAX)
    // -----------------------------------------------------------------
    $('#editCategoryForm').on('submit', function (e) {
        e.preventDefault();

        const categoryId   = $('#edit-category-id').val();
        const categoryName = $('#edit-category-name').val().trim();
        const url          = `/categories/${categoryId}/update`;
        let form= $(this); 

        if (!categoryName) {
            // showToast('Category name is required.', 'error');
            alert('Category name is required');
            return;
        }

        $.ajax({
            type: "PUT",   // Laravel expects PUT/PATCH for update
            url: url,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // Build a fresh category object for the helper
                    const updatedCategory = {
                        id: categoryId,
                        name: categoryName,
                        created_at: response.category.created_at   // keep original timestamp
                    };

                    // Replace the row in-place (fade-out → update → fade-in)
                    let $row = $(`#category-row-${categoryId}`);
                    $row.fadeOut('fast', function () {
                        // Re-use the same addCategoryToTable logic (removes old row & prepends new)
                        $row.remove();
                        addCategoryToTable(updatedCategory);
                        $row = $(`#category-row-${categoryId}`).hide();
                        $row.fadeIn('fast');
                    });

                        // Close the modal
                    $('#editCategoryModal').modal('hide');
                }
            },

            error: function (xhr, status, error) {
                    let response = xhr.responseJSON;
                  if (xhr.status === 422) {
                      if (response.errors.name) {
                        $('#edit-category-name').addClass('is-invalid');
                      }
                    } 
                  else {
                      alert("Error occurred"); 
                      //showToast(response.message || 'An error occurred.', 'error');
                    }
                  
            }
        });
    });

</script>
          


           


        
@endsection