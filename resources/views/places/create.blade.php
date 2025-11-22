@extends('layout')
@section('content')
<x-sidebar></x-sidebar>

    <div class="container vh-100 d-flex flex-column addTrip-form">
                <form action="/place/post" class="tops w-100" method="POST" enctype="multipart/form-data" id="place-upload">
                    @csrf
                    <!-- place-title -->
                    <div class="mb-3">
                        <label for="addDestinationTitle" class="form-label">Destination Place</label>
                        <input type="text" class="form-control {{$errors->has('logo') ? 'is-invalid':'' }}" id="addPlaceTitle" name='title' placeholder="Enter Destination Place" >
                        @error('title')
                        <span class="text text-danger"> {{$message}} </span>
                        @enderror
                    </div>
                    

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="addImage" class="form-label">Place Image</label>
                        <input type="file" class="upload form-control {{$errors->has('logo') ? 'is-invalid':'' }}"   name="logo[]" multiple>
                        @error('logo')
                         <span class="text text-danger"> {{$message}} </span>
                        @enderror

                    </div>




                    <div class="mb-2 selected">

                    </div>

                    <!-- submit -->
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success upload">Add Place</button>
                    </div>
                </form>

    </div>

        <script>
            const input= document.querySelector(".upload");
            const selectedFiles= document.querySelector(".selected");
        
            
            input.addEventListener('change',(e)=>{
                selectedFiles.innerHTML="";
                $files= e.target.files;
                for (let i = 0; i < $files.length; i++) {
                    fileName=$files[i]['name'];
                    console.log(fileName);
                    showSelected(fileName);
                    
                }
                
            })

            function showSelected(data){
                spans= document.createElement('span');
                spans.innerHTML=data+"<br>";
                selectedFiles.appendChild(spans); 
            }
            
        </script>

@endsection
   {{-- javascript --}}
        
        
            