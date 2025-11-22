<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class PlaceController extends Controller
{
    // shows the form
    public function create(){
        return view('places.create');
    }

    // to show all the places maybe categories..
    public function index(){
        $destination= Destination::with('image')->get();
        // dd($destination[2]->image);
        
    
        return view('places.index',['places'=>$destination,'categories'=>Category::all()]);
    }
    
    // to store new place
    public function store(Request $request){
        // dd($request->logo);
        $formfields= $request->validate([
            'title'=>'required',
        ]);

        $destination= Destination::create($formfields);

        if ($request->hasFile('logo')){
            foreach ($request->file('logo') as $image) {
                # code...
                $path= $image->store('logos','public');
                $destination->image()->create([
                    'path'=>$path,
                ]);



            }
            // $formfields['logo']= $request->file('logo')->store('logos','public'); 
        }
        
        return back()->with('message',"new destination is added");


    }
    
}
