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








                ## Trip Route(Travel_agent's) ##
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

        # Assign hotel #
Route::get("/trip/manage/assign/{trip}",[TripController::class,'assign']);
Route::post("/trip/hotel/assign",[TripController::class,'assignStore']);
Route::delete("/trip/hotel/remove/{trip}",[TripController::class,'assignDelete']);

            # Categories #
Route::get("/category/manage",[CategoryController::class,'index']);
Route::post("/category/post",[CategoryController::class,'store']);
// NEW: Route for deleting/editing a category
Route::get('/categories/{categoryId}/edit',[CategoryController::class,'edit']);
Route::put('/categories/{categoryId}/update',[CategoryController::class,'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

      # Places(Destinations) #
Route::get("/place/create",[PlaceController::class,'create']);
Route::post("/place/post",[PlaceController::class,'store']);
Route::get("/place/manage",[PlaceController::class,'index']);
Route::get('/place/{place}/edit', [PlaceController::class, 'edit']);
Route::post('/place/update/{place}', [PlaceController::class, 'update']);
Route::delete('/place/delete/{place}', [PlaceController::class, 'destroy']);
