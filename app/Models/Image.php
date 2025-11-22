<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable=[
        'destination_id',
        'path'
    ];
    public function destination(){
        return $this->belongsTo(Destination::class);
    }
}
