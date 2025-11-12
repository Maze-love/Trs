<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Admin extends User
{
    //
    use HasParent;
    
}
