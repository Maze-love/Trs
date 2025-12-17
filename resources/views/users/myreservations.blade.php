@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  
    
    <div class="container tops">
        <div class="text-center my-5">
            <h1 class="display-4">My Reservations</h1>
            <p class="lead">A timeline of your upcoming and past hotel stays.</p>
        </div>
         <!-- Search and Filter Section -->
        <div class="row mb-4 justify-content-end align-items-center">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search reservations..."
                        aria-label="Search reservations"
                    />
                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="button-search"
                    >
                    Search
                    </button>
                </div>
            </div>
            <div class="col-md-auto mt-3 mt-md-0">
                <button class="btn btn-outline-info w-100" type="button" data-bs-toggle="modal" data-bs-target="#myReviewsModal">
                    <i class="bi bi-star-half me-2"></i>My Reviews
                </button>
            </div>
            <div class="col-md-3 col-lg-2 mt-3 mt-md-0 position-relative">
                <button class="btn btn-outline-secondary w-100" type="button" id="filter-btn">
                    <i class="bi bi-filter me-2"></i>Filter
                </button>
                <div id="filter-form" class="card p-3 position-absolute" style="display: none; top: 100%; right: 0; z-index: 10; width: 250px;">
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="upcoming" id="statusUpcoming"/>
                                <label class="form-check-label" for="statusUpcoming">still booking remains!</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"type="checkbox" value="completed" id="statusCompleted"/>
                                <label class="form-check-label" for="statusCompleted">overall confirmed!</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="cancelled" id="statusCancelled"/>
                                <label class="form-check-label" for="statusCancelled">book your stay</label>
                            </div>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary btn-sm me-2">
                            Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                            Apply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
          <!-- Upcoming Reservation -->
        <div class="timeline" id="reservation-timeline">
            @include('partials._reservation_timeline', ['data' => $data])
        </div>

          <!-- My Reviews Modal -->
      <div class="modal fade" id="myReviewsModal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myReviewsModalLabel">
                My Hotel Reviews
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div id="reviews-container">
                <!-- Reviews will be loaded here via AJAX -->
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
<script>
      
      // filter page to be visible
      document.addEventListener("DOMContentLoaded", function () {
        const csrf = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';
        const filterBtn = document.getElementById("filter-btn");
        const filterForm = document.getElementById("filter-form");
        const timelineContainer = $('#reservation-timeline');

        filterBtn.addEventListener("click", function (event) { 
          event.stopPropagation();
          filterForm.style.display =
            filterForm.style.display === "none" ? "block" : "none";
        });

        document.addEventListener("click", function (event) {
          if (
            !filterForm.contains(event.target) &&
            event.target !== filterBtn
          ) {
            filterForm.style.display = "none";
          }
        });

        // AJAX filtering
        $('#filter-form input[type="checkbox"]').on('change', function() {
            let selectedStatuses = [];
            $('#filter-form input[type="checkbox"]:checked').each(function() {
                selectedStatuses.push($(this).val());
            });

            // Show loading spinner
            timelineContainer.html('<div class="text-center p-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            $.ajax({
                url: '/reservations/filter',
                type: 'GET',
                data: {
                    statuses: selectedStatuses,
                    _token: csrf
                },
                success: function(response) {
                    timelineContainer.html(response);
                },
                error: function(xhr) {
                    console.error('Error filtering reservations:', xhr);
                    timelineContainer.html('<p class="text-center text-danger">Could not load reservations.</p>');
                }
            });
        });

        // Reset button
        $('#filter-form button[type="button"]').on('click', function() {
            $('#filter-form input[type="checkbox"]').prop('checked', false);
            // Trigger change to reload all reservations
            $('#filter-form input[type="checkbox"]').first().trigger('change');
        });
      });

      // render's user's review inside modal
      document.addEventListener('DOMContentLoaded', function () {
        const myReviewsModal = document.getElementById('myReviewsModal');
        myReviewsModal.addEventListener('show.bs.modal', function () {
            const reviewsContainer = document.getElementById('reviews-container');
            reviewsContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            $.ajax({
                url: '/user/reviews',
                type: 'GET',
                dataType: 'json',
                success: function(reviews) {
                    reviewsContainer.innerHTML = '';
                    if (reviews.length > 0) {
                        reviews.forEach(function(review, index) {
                            const reviewDate = new Date(review.created_at);
                            const formattedDate = reviewDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                            let stars = '';
                            for (let i = 0; i < 5; i++) {
                                stars += `<span class="starability-star ${i < review.rating ? 'rated' : ''}"></span>`;
                            }

                            const reviewHtml = `
                                <div class="review-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">${review.hotel.name}, ${review.hotel.destination.title}</h6>
                                        <div class="starability-result" data-rating="${review.rating}">
                                            ${stars}
                                        </div>
                                    </div>
                                    <p class="text-muted small">Reviewed on: ${formattedDate}</p>
                                    <p class="review-comment bg-light p-3 rounded">
                                        ${review.comments}
                                    </p>
                                </div>
                                ${index < reviews.length - 1 ? '<hr />' : ''}
                            `;
                            reviewsContainer.innerHTML += reviewHtml;
                        });
                    } else {
                        reviewsContainer.innerHTML = '<p class="text-center">You have not posted any reviews yet.</p>';
                    }
                },
                error: function(xhr) {
                    reviewsContainer.innerHTML = '<p class="text-center text-danger">Could not load reviews.</p>';
                    console.error('Error fetching reviews:', xhr);
                }
            });
        });
    });
    

   
   
    const csrf = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrf } });

    // submit review via jQuery AJAX with inline status message + loading icon
    $(document).on('submit', '#reviewForm', function(e){
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();

        // clear previous validation/errors
        $('#ratingError').text("");
        $('#commentError').text("");
        $('#comment').removeClass('is-invalid');

        // modal context
        var $modal = form.closest('.modal');
        var $body = $modal.find('.modal-body');

        // store original modal body so we can restore it later (only once)
        if (!$body.data('original')) {
            $body.data('original', $body.html());
        }

        // remove any existing message area
        $body.find('#reviewMsg').remove();

        // show loading message with spinner (do not clear form yet)
        var $loading = $(
            '<div id="reviewMsg" class="alert alert-info d-flex align-items-center mb-3" role="alert">'
            + '<div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>'
            + '<div class="message">Posting review...</div>'
            + '</div>'
        );
        $body.prepend($loading);

        $.ajax({
            url: `/user/review/post`,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(json){
                // build success message
                var $success = $(
                    '<div id="reviewMsg" class="alert alert-success d-flex align-items-center mb-3" role="alert">'
                    + '<div class="spinner-border spinner-border-sm text-white me-2" role="status" aria-hidden="true"></div>'
                    + '<div class="message">' + (json.message || 'Review posted') + '</div>'
                    + '</div>'
                );

                // clear modal body and show only the success status
                $body.empty().append($success);

                // hide modal after a short delay
                setTimeout(function(){
                    $modal.modal('hide');
                }, 1400);
            },
            error: function(xhr){
                // remove loading indicator
                $body.find('#reviewMsg').remove();

                // keep modal content intact and show inline validation only
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.comments) {
                        $('#comment').addClass('is-invalid');
                        $('#commentError').text(errors.comments.join(' '));
                    }
                    if (errors.rating) {
                        $('#ratingError').text(errors.rating.join(' '));
                    }
                    return;
                }

                // fallback: log error to console
                console.error('Review post error', xhr);
            }
        });

        // when modal completely hidden, restore original modal-body content for future use
        $modal.one('hidden.bs.modal', function(){
            var original = $body.data('original') || '';
            $body.html(original);
        });
    });






 </script>
@endsection