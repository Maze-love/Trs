<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CategoryController;

Route::get("/login",[LoginController::class,'showLogin']);
Route::post("/login/post",[LoginController::class,'login']);
Route::get("/logout",[LoginController::class,'logout']);

Route::get("/register",[LoginController::class,'showRegister']);
Route::post("/register/post",[LoginController::class,'register']);

// hotel controller
Route::get("/hotel/index",[HotelController::class,'index']);








                        ### Trip controller ###
Route::get("/",[TripController::class,'index']);
                    
// filtering 
Route::post("/trip/filter",[TripController::class,'filter']);

/*- trip route-*/
Route::get("/trip/create",[TripController::class,'create']);
Route::get("/trip/view/{id}",[TripController::class,'show']);
Route::post("/trips/post",[TripController::class,'store']);
Route::get("/trip/manage",[TripController::class,'manage']);
Route::get("/trip/update/{trip}",[TripController::class,'update']);
Route::put("/trip/edit/{id}",[TripController::class,'edit']);
Route::delete("/trip/manage/delete/{trip}",[TripController::class,'destroy']);

/*assign hotel*/
Route::get("/trip/manage/assign/{trip}",[TripController::class,'assign']);
Route::post("/trip/hotel/assign",[TripController::class,'assignStore']);
Route::delete("/trip/hotel/remove/{trip}",[TripController::class,'assignDelete']);


/*- places (destination) route-*/
Route::get("/place/create",[PlaceController::class,'create']);
Route::post("/place/post",[PlaceController::class,'store']);
Route::get("/place/manage",[PlaceController::class,'index']);

/*-categories-*/
Route::get("/place/create",[PlaceController::class,'create']);
Route::post("/category/post",[PlaceController::class,'store']);
Route::post("/category/manage",[CategoryController::class,'store']);

