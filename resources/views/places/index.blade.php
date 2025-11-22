@extends('layout')
@section('content')

<x-sidebar></x-sidebar>

<!-- Add Trip a -->
  




 <x-column class="container tops">

            <form action="/category/manage" class="tops w-50" method="POST" enctype="multipart/form-data" id="addCat" >
                                @csrf
                    <!-- place-title / category form-->
                    <div class="mb-3">
                        <label for="addCategoryTitle" class="form-label">Category</label>
                        <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid':'' }}" id="addCategoryTitle" name='name' placeholder="Create Category.." >
                        @error('name')
                        <span class="text text-danger"> {{$message}}</span>
                        @enderror
                    </div>
                    
                    <!-- submit -->
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" >Add Category</button>
                    </div>
            </form>

            <hr>
            <div class="my-3">
                <a type="" class="btn btn-primary" href="/place/create">Add New Destination </a>
            </div>  
            <table class="table table-striped table-hover ">
                <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Image</th>
                        </tr>
                </thead>
                <tbody>
                    @if ($places->count()==0)
                        <tr>
                           
                            <td>no data</td>
                        </tr>
                    @endif
                    @foreach ($places as $place)
                        <tr>
                             <td>{{$place->title}}</td>
                            <td>      
                                @php
                                    $pImages= $place->image;

                                @endphp  
                                @if (!$pImages->isEmpty())
                                    <img src="{{$pImages?asset('storage/'.$pImages[0]->path):asset('/images/blog-1.jpg')}}" class="table-img" alt="">
                                @else 
                                    <img src="{{asset('/images/blog-1.jpg')}}" class="table-img" alt="">

                                @endif
                                    {{-- <img src="{{$place->image?asset('storage/'.$place->logo):asset('/images/blog-1.jpg')}}" class="table-img" alt=""> --}}


                            </td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="/edit/place/{{$place->id}}">Edit</a>
                                <a class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        
                    @endforeach
                   
                   
                
                </tbody>
            </table>
            <hr>


             <div class="my-3">
                <a type="" class="btn btn-primary" href="#addCat">Add New Category </a>
            </div>  
            <table class="table table-striped table-hover ">
                <thead>
                        <tr>
                            <th>Category</th>
                                                     
                        </tr>
                </thead>
                <tbody>
                    @if ($categories->count()==0)
                        <tr>
                           
                            <td>no data</td>
                        </tr>
                    @endif
                    @foreach ($categories as $category)
                        <tr>
                             <td>{{$category->name}}</td>
                            
                            <td>
                                <a class="btn btn-sm btn-warning" href="/edit/place/{{$category->id}}">Edit</a>
                                <a class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        
                    @endforeach
                   
                   
                
                </tbody>
            </table>

 </x-column>




           


        
@endsection