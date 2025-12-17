<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table="reservation";
    //
    protected $fillable=[
        'status','hotel_id','trip_id'
    ];
    public function trip(){
        return $this->belongsTo(Trip::class);
    }
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
    

    // a reservation belongs to a single customer
    public function customer(){
        return $this->belongsTo(Customer::class,'user_id');
    }

    public function getTripId(){
        return $this->trip->id;
    }


 

}
