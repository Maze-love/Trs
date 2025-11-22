<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    //
    use HasFactory;
    protected $fillable=['title'];


    // protected $with=['image'];
    public function trip(){
        return $this->hasMany(Trip::class);
    }
    public function image(){
        return $this->hasMany(Image::class);
    }
    public function hotel(){
        return $this->hasMany(Hotel::class);
    }
    
    
}
