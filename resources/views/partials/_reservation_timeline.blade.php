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



@empty
<div class="text-center py-5">
    <p class="lead">No reservations found.</p>
</div>
@endforelse