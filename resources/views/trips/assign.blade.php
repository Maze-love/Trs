@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  
   
<div class="container tops card border-0">
            <h5 class="trip-title card-header">{{$trip->title}}</h5>     
               {{-- form to remove all assigned hotel 
                (to be moved on the edit section of the trip)--}}
            <div class="card-body ">
                     <form action="/trip/hotel/assign" class="container-fluid" method="POST">
                        @csrf
                            <h6 class="form-title my-3" >Select Accomodation</h6>  
                            <input type="text" class="form-input-check" hidden name="trip_id" value="{{$trip->id}}">
                            <div class="row justify-content-center g-3" >     
                                {{-- checks hotels existence --}}
                                @php
                                    $noHotel=true;
                                @endphp

                                @if ($hotels->count()<1)
                                
                                <section class="col-md-7 col-7">
                                    <div class="alert alert-danger">
                                        No Hotels available for your trip!!
                                    </div>
                                </section>

                                @else
                                    
                                    @foreach ($hotels as $hotel)
                                        {{-- shows unassigned hotels only --}}

                                        @if (!$trip->hotel->contains($hotel->id))
                                            {{$noHotel= false}}
                                            <div class="col-md-4 col-7">
                                                <div class="card relative">
                                                    <img src="/images/blog-1.jpg" class="card-img-top" alt="Hotel 1">

                                                    <div class="card-body ">
                                                        <div class="hotel-title my-0">
                                                            <input class="form-check-input position-absolute top-0 start-25 bg-dark" type="checkbox" name="hotel_id[]"  value={{$hotel->id}}>
                                                            <h5 class="card-title">{{$hotel->name}}</h5>    
                                                        </div>

                                                        <p class="hotel-description">
                                                            <strong>Rating:
                                                            @for ($i = 0; $i < $hotel->ratings; $i++)
                                                                </strong>★
                                                            @endfor
                                                            <br>
                                                            <strong>Location:</strong> {{$trip->destination ? $trip->destination->title: "null"}}
                                                        </p>

                                                    </div>
                                                    
                                                    <div class="card-footer  p-0">
                                                        <a href="/hotel/view/{{$hotel->id}}" class="btn btn-outline-primary btn-sm w-100" >See more</a>

                                                    </div>

                                                </div>
                                            </div> 
                                        
                                        @endif 
                                
                                    @endforeach
                                     @if ($noHotel)
                                        <div class="col-md-7 col-7">
                                                <div class="alert alert-warning">
                                                    No Additional Hotels To Select At the moment!!
                                                </div>
                                        </div>
                                     @endif
                                       
                                @endif
                             
                               

                               

                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-3 ">Save</button>

                
                     </form>


                     
                    <form action="/trip/hotel/remove/{{$trip->id}}"  method="POST" class="" >
                        @csrf
                        @method("DELETE")
                        
                        <button type="submit" class="btn btn-sm btn-danger mt-3 position-relative">Remove All
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                {{$trip->getHotels()}}
                                </span>
                        </button>
                    </form>

            </div>
</div>
               



<script>
    let lists= document.querySelector('.hotel-parts');
    lists.addEventListener('click',()=>{

    })  
</script>
@endsection