@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  

    <div class="tops addTrip-form mx-auto ">

            <div class="addTrip-form ">
                <div class="header text-center">
                    <h4>Login</h4>
                </div>
                <form action="/login/post" class="px-3" method="POST">
                    @csrf
                        <div class="form-group  mb-3 ">
                            <label for="">Email</label>
                            <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid':'' }}" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Password</label>
                            <input type="password " class="form-control" name="password" placeholder="Enter password">
                            
                            @error('password')
                                 <span class="text text-danger"> {{$message}} </span>
                            @enderror

                        </div>
                        <div class="form-group mb-3 w-75 mx-auto ">
                            <button class="btn btn-primary w-100">Login</button>
                        </div>
                </form>
            </div>
    </div>

@endsection
