    <!-- card4 -->
@foreach ($trips as $trip)
    
    <div class="card card-1">
        <div class="card-header">
        @php
                $path= $trip->destination;
                // dd($path->image->count())
        @endphp
            <img src="{{$path->image->count()>0 ? asset('storage/'.$path[0]->path): asset('/images/blog-1.jpg')}}" alt="p-3">
            <span class="date">{{$trip->date}}</span>
        </div>
        <div class="card-body">
            <a href="/trip/view/{{$trip->id}}" class="trip-title">{{$trip->title}}</a>
            <div class="trip-info">
                <span class="category">Category: {{$trip->category ? $trip->category->name : "null"}}</span><br>
                <span class="price mr-1">Price:<i class="fa fa-dollar"> {{$trip->price}}</i></span>
                <div class="infos ">
                    <span class="destination me-1"><i class="fa-solid fa-location-dot"> </i>{{$trip->destination ? $trip->destination->title: "null"}}</span>|
                    <span class="duration"><i class="fa-regular fa-clock"></i> {{$trip->duration}} days</span>
                </div>
                <div class="status">
                    @php
                        $number= $trip->hotel->count();
                    @endphp
                            @if ($number<1)
                            
                                 <span class="badge text-bg-danger">Unavailable</span>

                            @else
                                 <span class="badge text-bg-success">{{$number}} Hotel available</span>
                                
                            @endif
                </div>
            </div>
            
        </div>
    </div>

    
@endforeach
 

