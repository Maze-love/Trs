@extends('layout')
@section('content')
<x-sidebar></x-sidebar>
 <!-- Add Trip form -->
        <div class="container tops py-3 addTrip-form ">
                        <h5 class="form-title" id="addTripModalLabel">Add New Trip</h5>  
                         <!-- Trip Form -->
                        <form action="/trips/post" class=" my-auto w-100" method="POST">
                            @csrf
                            <!-- Trip Title -->
                            <div class="mb-3">
                                <label for="addTripTitle" class="form-label">Trip Title</label>
                                <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid':'' }}"  placeholder="Enter trip title" name="title">
                                 @error('title')
                                 <span class="text text-danger"> {{$message}} </span>
                                 @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label for="addCategory" class="form-label">Category</label>
                                <select class="form-select {{$errors->has('category_id') ? 'is-invalid':'' }}"  name="category_id">
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>

                                    @endforeach
                                    
                                </select>
                                 @error('category_id')
                                 <span class="text text-danger"> {{$message}} </span>
                                 @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="addPrice" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control {{$errors->has('price') ? 'is-invalid':'' }}"  placeholder="Enter price" name="price" >
                                </div>
                                @error('price')
                                <span class="text text-danger"> {{$message}} </span>
                                @enderror
                            </div>

                            <!-- Destination -->
                            <div class=" mb-3 ">
                                <label for="addDestination" class="formlabel">Destination</label>
                                <select class="form-select {{$errors->has('destination_id') ? 'is-invalid':'' }}"  name="destination_id" >
                                    <option  disabled selected>Select a destination</option>
                                    @foreach ($places as $place)
                                        <option value="{{$place->id}}">{{$place->title}}</option>
                                    @endforeach
                                   
                                </select>
                                 @error('destination_id')
                                 <span class="text text-danger"> {{$message}} </span>
                                @enderror
                                
                    
                            </div>
                            

                            <!-- Duration -->
                            <div class="mb-3">
                                <label for="addDuration" class="form-label">Duration</label>
                                <div class="input-group">
                                    <input type="number" class="form-control {{$errors->has('duration') ? 'is-invalid':'' }}"  placeholder="Enter duration" name="duration" >
                                    <span class="input-group-text">Days</span>
                                </div>
                                 @error('duration')
                                <span class="text text-danger"> {{$message}} </span>
                             @enderror
                            </div>


                            <!-- Date -->
                            <div class="mb-3">
                                <label for="addDate" class="form-label">Date</label>
                                <input type="date" class="form-control {{$errors->has('date') ? 'is-invalid':'' }}"  name="date">
                                 @error('date')
                                <span class="text text-danger"> {{$message}} </span>
                                @enderror
                            </div>

                            <!-- description -->
                             <div class="mb-3">
                                <label for="addDescription" class="form-label">Description</label>
                                <textarea class="form-control {{$errors->has('description') ? 'is-invalid':'' }}" name="description"  rows="4"></textarea>
                                @error('description')
                                <span class="text text-danger"> {{$message}} </span>
                                @enderror
                             </div>
                             
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Add Trip</button>
                        </form>
             
        </div>
@endsection