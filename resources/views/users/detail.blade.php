@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  
    
    <div class="container tops ">
        
        <!-- Page Header -->
        <div class="manage-header text-center">
            <h1 class="display-5">Manage Your Stay</h1>
            <p class="lead mb-0">{{$data->hotel->name}}, {{$data->hotel->destination->title}}</p>
        </div>


        <div class="row g-4">

            <!-- Left Column: Main Actions & Details -->
            <div class="col-lg-7 col-xl-8">
                
                <!-- Reservation Details Widget -->
                <div class="widget-card">
                    <div class="widget-header d-flex justify-content-between align-items-center">
                        <h5><i class="bi bi-info-circle-fill me-2"></i>Reservation Details</h5>
                        <div class="statuses">
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill">{{$data->status}}</span>
                            <span class="badge bg-success-subtle text-success-emphasis"></span>

                        </div>
                        
                    </div>
                    <div class="widget-body">
                        <ul class="list-group list-group-flush">
                           
                          
                            
                        </ul>
                    </div>
                </div>

                <!-- Modification Widget -->
                <div class="widget-card">
                    <div class="widget-header">
                        <h5><i class="bi bi-pencil-square me-2"></i>Modify Your Booking</h5>
                    </div>
                    <div class="widget-body">
                        <p class="text-muted">Need to make a change? Changes are subject to availability and may affect the total price.</p>
                        <div class="d-grid gap-2 d-sm-flex">
                            <button class="btn btn-primary"><i class="bi bi-calendar-event me-2"></i>Change Dates</button>
                            <button class="btn btn-outline-secondary"><i class="bi bi-door-closed me-2"></i>Change Room</button>
                            <button class="btn btn-outline-secondary"><i class="bi bi-card-text me-2"></i>Add Special Request</button>
                        </div>
                    </div>
                </div>
                
                 <!-- Cancellation Widget -->
                <div class="widget-card">
                    <div class="widget-header">
                        <h5><i class="bi bi-x-circle-fill me-2 text-danger"></i>Cancel Reservation</h5>
                    </div>
                    <div class="widget-body">
                        <div class="cancellation-policy mb-3">
                            <p class="fw-bold mb-1">Free cancellation before 11:59 PM on September 8, 2025.</p>
                            <p class="mb-0 small">Cancellations made after this time are non-refundable.</p>
                        </div>

                        <form action="/reserve/update" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="text" name="reservation_id" value="{{$data->id}}" hidden>
                            <button type="submit" class="btn btn-danger w-100 w-sm-auto" name="cancel" value="cancel"><i class="bi bi-trash-fill me-2"></i>Proceed with Cancellation</button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Right Column: Contextual Info -->
            <div class="col-lg-5 col-xl-4">
                
                <!-- Hotel Info Widget -->
                <div class="widget-card">
                    <div class="hotel-map"></div>
                    <div class="widget-body">
                        <h5 class="card-title">{{$data->hotel->name}}, {{$data->hotel->destination->title}}</h5>
                        <p class="card-text text-muted"><i class="bi bi-geo-alt-fill me-2"></i>109 East 42nd Street, New York, NY 10017</p>
                        <div class="d-grid gap-2">
                             <a href="#" class="btn btn-outline-primary"><i class="bi bi-telephone-fill me-2"></i>Contact Hotel</a>
                             <a href="#" class="btn btn-outline-secondary"><i class="bi bi-sign-turn-right-fill me-2"></i>Get Directions</a>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Widget -->
                <div class="widget-card">
                    <div class="widget-header">
                        <h5><i class="bi bi-receipt-cutoff me-2"></i>Price Summary</h5>
                    </div>
                    <div class="widget-body">
                        <ul class="list-group list-group-flush">
                          
                           
                        </ul>
                    </div>
                </div>

            </div>
            
        </div>
    </div>


@endsection