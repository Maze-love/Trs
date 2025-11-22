<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TravelAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // store new categories
    public function store(Request $request){
        $user_id= Auth::user()->id;
        $agent= TravelAgent::find($user_id);

        $formfield= $request->validate([
            'name'=>'required'
        ]);

        $agent->createCategories($formfield);

        
        return back()->with('message','category is added');
    }
    // 
    public function edit(){
        
    }


}
