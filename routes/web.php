<?php

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get("/login",[LoginController::class,'showLogin']);
Route::post("/login/post",[LoginController::class,'login']);
Route::get("/logout",[LoginController::class,'logout']);

Route::get("/register",[LoginController::class,'showRegister']);
Route::post("/register/post",[LoginController::class,'register']);

// hotel controller
Route::get("/hotel/index",[HotelController::class,'index']);








// trip controller