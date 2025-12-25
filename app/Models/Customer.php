<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Customer extends User
{
    //
    Use HasParent;

    public function reservation(){
        return $this->hasMany(Reservation::class);
    }
    public function firstLetter(){
        return $this->name[0];
    }

    // customer books a trip
    public function bookTripHotel($data){
        $this->reservation()->create($data);
        $this->save();
    }

    // customer's reservation
    // either returns the specific reservation or all
    public function getReservation($id=null){
       return $id ?$this->reservation->find($id) : $this->reservation;
    }

    // update(cancel) reservation
    public function cancelReservation($id){
        $this->reservation()->find($id)->update(['status'=>'cancelled']);
    }

    
    
}
