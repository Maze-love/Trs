<?php

namespace App\Models;

use Parental\HasParent;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class TravelAgent extends User
{
    //
    Use HasParent;
     public function createPackage($data){
       return $this->trips()->create($data);

    }
    public function updatePackage($data,$id){
        $this->trips()->find($id)->update($data);
    }

    public function deletePackage(Trip $trip){
        $trip->delete();
    }

    public function createCategories($data){
        Category::create($data);
    }

    public function updateCategory($data){
        Category::update($data);
    }

    // assign hotel for specific trip
    public function AssignHotel($trip_id,$hotel_id){
        $trip= $this->trips()->find($trip_id);
        $trip->hotel()->attach($hotel_id);
        $trip->setStatus('available');

    }

    // remove all assigned hotel
    public function RemoveHotel(Trip $trip){
        $trip->hotel()->detach();
        $trip->setStatus('unavailable');
        // $this->save();
    }

    public function trips(){
        return $this->hasMany(Trip::class);
    }
    
}
