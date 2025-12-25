<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    // shows the form
    public function create(){
        return view('places.create');
    }

    // to show all the places
    public function index(){
        $destination= Destination::with('image')->get();
        return view('places.destinations',['places'=>$destination]);
    }
    
    // to store new place
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'      
        ]);
   
        if ($validator->passes()){
            // Create the new destination
            $formfield= $validator->validated();
            $destination= Destination::create($formfield);

            if ($request->hasFile('logo')){
                foreach ($request->file('logo') as $image) {
                    $path= $image->store('logos','public');
                    $destination->image()->create([
                        'path'=>$path,
                    ]);
                }
            }
        
        $destination->load('image');
            return response()->json([
                'success' => true,
                'message' => 'New destination added successfully!',
                'destination' => $destination
            ], 201); // 201 Created

        } 
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
        

    }
    
    public function destroy(Destination $place){
        $place->image()->delete();
        $place->delete();

        return response()->json(['success' => true, 'message' => 'Destination deleted successfully!']);
    }
    
    public function edit(Destination $place){
        return response()->json($place);
    }

    public function update(Request $request, Destination $place){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'logo.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $formFields = $validator->validated();
        $place->update(['title' => $formFields['title']]);

        if ($request->hasFile('logo')) {
            // Delete old images first
            $place->image()->delete();

            foreach ($request->file('logo') as $image) {
                $path = $image->store('logos', 'public');
                $place->image()->create(['path' => $path]);
            }
        }

        $place->load('image');

        return response()->json([
            'success' => true,
            'message' => 'Destination updated successfully!',
            'destination' => $place
        ]);
    }


    
}
