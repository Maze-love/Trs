<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'ratings',
        'destination_id',
        'contact_info'
    ];
    protected $attributes=[
        'ratings'=>3
    ];


    protected $hidden=[
        'destination_id',
        'created_at','updated_at'
    ];

    public function destination(){
        return $this->belongsTo(Destination::class);
    }
    public function trip(){
        return $this->belongsToMany(Trip::class);
        // return $this->belongsToMany(Trip::class)->withPivot('status')->withTimestamps();

    }
    
    // is managed by a single Manager
    public function manager(){
        return $this->belongsTo(Manager::class,'user_id');
    }




    
}
