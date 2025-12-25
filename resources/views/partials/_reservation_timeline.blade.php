@forelse ($data as $reservation)


<div class="timeline-item ">
    <div class="timeline-icon">
        <i class="bi bi-briefcase-fill"></i>
    </div>
    <div class="timeline-content">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="hotel-name mb-0">{{$reservation->trip->title}}</h4>
            

        </div>

        <p class="reservation-date text-muted">October 20-25, 2025</p>
        <hr>

        <ul class="details-list">
            <!-- room details-->
            <li class="text-muted"><i class="bi bi-geo-alt-fill"></i>{{$reservation->hotel->name}} ,{{$reservation->hotel->destination->title}}</li>
           
            
            
        </ul>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-outline-primary btn-sm" href="/reserve/show/{{$reservation->id}}" type="button">Manage Reservation</a>
            <button class="toggle-modal-btn btn btn-outline-secondary btn-sm" data-bs-target="#addReview" data-bs-toggle="modal">
                    Leave a Review
            </button>                   
         </div>
    </div>
</div>


<div class="modal fade" id="addReview" tabindex="-1"   aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="mb-1">Review Your Stay!</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body">
                <h5 class="my-4 text-muted">Add Your Comment</h5>
                <hr/>
                <form action="/user/review/post" id="reviewForm" method="POST">
                    @csrf
                    <input type="hidden" id="hotel_id" name="hotel_id" value="{{$reservation->hotel_id}}">
                    <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id()}}">

                    <div class="starability-basic">
                        <input type="radio" id="rate5" name="rating" value="1" />
                        <label for="rate5" title="Amazing">5 stars</label>
                        <input type="radio" id="rate4" name="rating" value="2" />
                        <label for="rate4" title="Very good">4 stars</label>
                        <input type="radio" id="rate3" name="rating" value="3" />
                        <label for="rate3" title="Average">3 stars</label>
                        <input type="radio" id="rate2" name="rating" value="4" />
                        <label for="rate2" title="Not good">2 stars</label>
                        <input type="radio" id="rate1" name="rating" value="5" />
                        <label for="rate1" title="Terrible">1 star</label>
                        <span class="text text-danger" id="ratingError"></span>

                    </div>

                    <div class="form-group mb-1">
                        <label for="">Comment</label>
                        <textarea class="form-control" name="comments" id="comment" rows="4" placeholder="During stay @ {{$reservation->hotel->name}} & {{$reservation->trip->title}}"
                        ></textarea>
                        <span class="text text-danger" id="commentError"></span>
                    </div>
                    <button class="btn btn-secondary btn-round btn-d mt-1" type="submit">
                        PostComment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


@empty
<div class="text-center py-5">
    <p class="lead">No reservations found.</p>
</div>
@endforelse