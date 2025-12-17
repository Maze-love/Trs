@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  
  
  
  
<x-column class="trip-detail-container tops">
            <!-- Image Slider -->
            <div id="tripCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if ($trip->destination)
                            @foreach ($trip->destination->image as $item)
                                    {{-- {{$item}} --}}
                                <div class="carousel-item active">
                                    <img src="{{asset('storage/'.$item->path)}}" class="d-block w-100" alt="Trip Image 1">
                                </div>
                            @endforeach
                            
                    @else
                        <div class="carousel-item active">
                            <img src="{{asset('/images/blog-1.jpg')}}" class="d-block w-100" alt="Trip Image 1">
                            
                        </div>
                        
                    @endif 
                </div>

                {{-- buttons  --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#tripCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tripCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Tabbed View -->
            <ul class="nav nav-tabs mt-1 " id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab"  data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary" type="button" role="tab" aria-controls="itinerary" aria-selected="false">Itinerary</button>
                </li>
               
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <h3>Trip Overview</h3>
                    <p>
                        {{$trip->getDescription()}}
                    </p>
                    <ul>
                        {{-- <li><strong>Destination:</strong>{{$trip->destination ? $trip->destination->title: "null"}}</li> --}}
                        <li><strong>Destination:</strong>{{$trip->getDestination()}}</li>
                        
                        <li><strong>Duration:</strong> {{$trip->getDuration()}}</li>
                        <li><strong>Price:</strong>{{$trip->getPrice()}}</li>
                        {{-- <li><strong>Category:</strong> {{$trip->category ? $trip->category->name : "null"}}</li> --}}
                        <li><strong>Category:</strong> {{$trip->getCategory()}}</li>
                
                    </ul>
                </div>

                <!-- Itinerary Tab -->
                <div class="tab-pane fade" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab">
                    <h3>Trip Itinerary</h3>
                    <ol>
                        <li><strong>Day 1:</strong> Arrival in Paris and check-in to the hotel.</li>
                        <li><strong>Day 2:</strong> Visit the Eiffel Tower and Louvre Museum.</li>
                        <li><strong>Day 3:</strong> Explore Montmartre and Sacré-Cœur Basilica.</li>
                        <li><strong>Day 4:</strong> Day trip to Versailles Palace.</li>
                        <li><strong>Day 5:</strong> Seine River cruise and Notre-Dame Cathedral.</li>
                        <li><strong>Day 6:</strong> Shopping and exploring local markets.</li>
                        <li><strong>Day 7:</strong> Departure from Paris.</li>
                    </ol>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <h3>Customer Reviews</h3>
                    <div class="review">
                        <p><strong>John Doe:</strong> "Great trip! Highly recommended."</p>
                    </div>
                    <div class="review">
                        <p><strong>Jane Smith:</strong> "Amazing experience. Will book again!"</p>
                    </div>
                   
                </div>
  
            </div>
        
          

          
</x-column>

<x-column class="trip-detail-container">
      <!-- Hotel Tab -->
                @php
                    $user_id= Auth()->user()->id ?? null;
                @endphp
                <form method="post" action="/hotel/trip/reserve" >
                    @csrf
                    <div class="row justify-content-center g-3" id="hotel-lists">
                        <h5 class="my-3 text-center">Available Hotels</h5>
                        {{-- display a lists of hotel --}}
                        @foreach ($trip->hotel as $hotel)
                        <div class="col-md-5 col-7">
                            <div class="card relative">
                                <img src="/images/blog-1.jpg" class="card-img-top" alt="Hotel 1">

                                <div class="card-body">

                                    <div class="hotel-title my-0">
                                        <input class="form-check-input position-absolute top-0 start-25 bg-dark" type="radio" name="hotel_id"  value={{$hotel->id}}>
                                        <h5 class="card-title">{{$hotel->name}}</h5>   
                                        <span class="badge bg-success">status</span>                                                                                        
                                    </div>

                                    <p class="hotel-description">
                                        <strong>Rating:
                                        @for ($i = 0; $i < $hotel->ratings; $i++)
                                        </strong>★
                                        @endfor
                                        <br>
                                        <strong>Location:</strong> {{$hotel->destination ? $hotel->destination->title: "null"}}
                                    </p>
                                </div>
                                
                                <div class="card-footer  p-0">
                              
                                    <a href="/hotel/view/{{$hotel->id}}" class="btn btn-outline-primary btn-sm w-100" >See more</a>

                                </div>

                            </div>
                        </div> 
                        @endforeach
                        
                    </div>
                    <input type="text" name="trip_id" value="{{$trip->id}}" hidden>
                    @error('hotel_id')
                        <span class="text text-danger"> {{$message}} </span>
                    @enderror
                    <!-- Reservation Button -->
                    <div class="reservation-button my-5">
                        <button  type="submit" class="btn btn-primary btn-lg reservation">
                            <i class="fas fa-calendar-check"></i> Reserve Your Trip Now
                        </button>
                    </div>
                   
                    
                </form>
                
</x-column>

<script>
        

        // selection made button visible
        function eves(){
                 
            $('input[type="radio"]').change(function(){
                if ($(this).is(':checked')){
                    console.log('checked');
                    $('.reservation-button').show();

                }
                
            })
     



        }
        
        eves();
   $('.reservation-button').hide();

   
      


</script>
@endsection
