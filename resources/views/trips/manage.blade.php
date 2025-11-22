@extends('layout')
@section('content')
<x-sidebar></x-sidebar>



 <x-column class="container tops card border-0">
            <!-- Add Trip a -->
            <div class="mb-3">
                <a type="a" class="btn btn-primary" href="/trip/create">Add New Trip </a>
            </div>
            
            <!-- search form -->        
            <div class="card-header py-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h5 class="mb-2 mb-md-0">
                        <i class="bi bi-list-ul me-2"></i>All Trips
                    </h5>
                    <div class="input-group" style="max-width: 300px">
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            placeholder="Search by name, price, duration, confirmation..."/>

                        <button class="btn btn-outline-secondary btn-sm" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Trip Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover ">
                
                    

                        
                        @if ($trips->count()<1)
                            <tr>
                                no data
                            </tr>
                            
                        @else

                        @foreach ($trips as $trip)
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Destination</th>
                                <th>Duration</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        
                        <tr>
                            <td>{{$trip->title}}</td>
                            <td>{{$trip->category ? $trip->category->name : "null"}}</td>
                            <td>{{$trip->price}}</td>
                            <td>{{$trip->destination ? $trip->destination->title: "null"}}</td>
                            <td>{{$trip->duration}}</td>
                            <td>{{$trip->date}}</td>

                            <td><span class="badge rounded-pill text-bg-primary">{{$trip->status}}</span></td>

                            <td>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle mb-1" type="button" data-bs-toggle="dropdown">
                                        Manage
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <li><a class="dropdown-item" href="/trip/update/{{$trip->id}}">Edit</a></li>
                                        <li><a class=" dropdown-item" href="/trip/manage/assign/{{$trip->id}}">Assign Hotel</a></li>
                                    </ul>
                                </div>

                                <form action="/trip/manage/delete/{{$trip->id}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>   
                                </form>

                            </td>
                        </tr>
                            
                        @endforeach
                        @endif

                        
                        

                </table>
            </div>
                

 </x-column>