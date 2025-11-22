<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    //
    protected $fillable=[
        'title', 'category_id', 'price', 'destination_id', 'duration', 'date', 'description',
        'status' 
    ];
    
    // protected $with=[
    //     'destination',
    //     'category',
    // ];
    protected $hidden=[
        'id','category_id','destination_id',
        'created_at','updated_at'
    ];

    public function scopeFilter($query, array $filters){ 
        if($filters['search'] ?? false){
            $query->where('title','like','%'.request('search').'%')
            ->orWhere('status','like','%'.request('search').'%')
            ->orWhereHas('destination',function($q){
                $q->where('title','like','%'.request('search').'%');
            })
            ->orWhereHas('category',function($q){
                $q->where('name','like','%'.request('search').'%');
            });

        }

    }

    public function setStatus($availablity){
        $this->attributes['status']=$availablity;
        $this->save();
    }

    public function getPrice(){
        return $this->attributes['price'];
    }
    public function getTitle(){
        return $this->attributes['title'];
    }
    public function getDuration(){
        return $this->attributes['duration'].' days';
    }
    public function getDescription(){
        return $this->attributes['description'];
    }
    public function getDestination(){
        return $this->destination['title']?? 'null';
    }
    public function getDestinationID(){
        return $this->destination['id']?? 'null';

    }
    public function getCategory(){
        return $this->category['name'] ?? 'null';
    }
    public function getHotels(){
        return $this->hotel()->count();
    }

    public function destination(){
        return $this->belongsTo(Destination::class);
    } 
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function hotel(){
        return $this->belongsToMany(Hotel::class);
        // ->withPivot('status')
        // ->withTimestamps()
    }

    public function travelAgent(){
        return $this->belongsTo(TravelAgent::class,'user_id');
    }
    

}
