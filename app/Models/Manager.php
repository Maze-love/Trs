<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

// Hotel Manager
class Manager extends User
{
    //
    use HasParent;
    use HasFactory;
    public function hotel(){
        return $this->hasOne(Hotel::class,'user_id');
    }

    
}
