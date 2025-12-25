@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  

    <section class="container  tops">
        <h2>Manage Reservation</h2>
                    <!-- Booking table goes here -->
        <div class="table">
            <table class="table table-striped table-hover ">
                <thead class="table-dark">
                    <tr>
                        <th>Client / Conf. #</th>
                        <th>Trip</th>
                        <th>Hotel</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                        {{-- <td>{{$item}}</td> --}}
                        <td>
                            <div class="d-flex align-items-center">
                                        <div class="user-avatar">{{$item->customer->firstLetter()}}</div>
                                        <div>
                                            <div class="fw-bold">{{$item->customer->name}}</div>
                                            {{-- <div class="small text-muted">HYT-84B2-99A1</div> --}}
                                        </div>
                            </div>
                        </td>

                        <td>{{$item->trip->title}}</td>
                        <td>{{$item->hotel->name}}</td>
                        
                        <td><span class="badge {{ $item->status ==='confirmed' ? 'bg-primary': 'bg-dark'}}">{{$item->status}}</span></td>
                        <td>
                        {{-- <form action="/hotel/trip/reserve/manage/{{$item->id}}" method="POST" >
                                @csrf
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal" name="confirm" value="confirm">Confirm</button>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#pendModal" name="pend" value="pend">Pend</button>
                                <button class="btn btn-sm btn-danger"  type="submit" name="cancel" value="cancel">Cancel</button>
                                <button class="btn btn-sm btn-danger"  type="submit" name="delete" value="delete">Delete</button>
                        </form> --}}
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle mb-1" type="button" data-bs-toggle="dropdown">
                                Manage
                            </button>
                                <div class="dropdown-menu">
                                    <form action="/hotel/trip/reserve/manage/{{$item->id}}" method="POST" class="">
                                        @csrf
                                        <button class="dropdown-item btn btn-sm btn-success"  name="confirm" value="confirm">Confirm</button>
                                        <button class="dropdown-item btn btn-sm btn-warning"  name="pend" value="pend">Pend</button>
                                        <button class="dropdown-item btn btn-sm btn-danger"   name="cancel" value="cancel">Cancel</button>
                                        <button class="dropdown-item btn btn-sm btn-danger"   name="delete" value="delete">Delete</button>
                                    </form>
                                        
                                </div>
                               
                        </div>
                            

                        </td>
                    </tr>
                    @endforeach
                    
                    <!-- Add more rows dynamically via JS/API -->
                </tbody>
            </table>
        </div> 
    </section>

    <script>

    </script>





@endsection

