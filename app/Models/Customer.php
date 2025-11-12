<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Customer extends User
{
    //
    Use HasParent;
    
    
}
