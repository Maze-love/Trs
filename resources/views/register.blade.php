@extends('layout')
@section('content')
<x-sidebar></x-sidebar>  

    <div class="tops container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-3">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                        <div class="card-body">
                            <form action="/register/post" method="POST">
                                @csrf
                                <div class="row mb-3 ">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control {{$errors->has('name') ? 'is-invalid':'' }}" type="text" name='name' placeholder="Enter your first name" />
                                            <label for="inputFirstName">name</label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" />
                                            <label for="inputLastName">Last name</label>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control email {{$errors->has('email') ? 'is-invalid':'' }}" type="email" name="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>

                                        @error('email')
                                            <span class="text text-danger"> {{$message}} </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6 mt-2 mb-2">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control {{$errors->has('username') ? 'is-invalid':'' }}"  type="text" name="username" placeholder="Create a username" />
                                            <label for="username">Username</label>
                                        </div>
                                </div>
                               

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control {{$errors->has('password') ? 'is-invalid':'' }}"  type="password" name="password" placeholder="Create a password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" type="password" placeholder="Confirm password" name="password_confirmation" />
                                            <label for="inputPasswordConfirm">Confirm Password</label>

                                            @error('password_confirmation')
                                                <span class="text text-danger"> {{$message}} </span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid"><button class="btn btn-dark" type="submit">Create Account</button></div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="/login">Have an account? Go to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@endsection