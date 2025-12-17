<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TravelAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    
    public function index(){
        return view('places.index',['categories'=>Category::all()]);
    }

    // store new categories
    public function store(Request $request){
        $user_id= Auth::user()->id;
        $agent= TravelAgent::find($user_id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        //  Handle Validation Failure
        // If validation fails, return a JSON response with the errors.
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
        if ($validator->passes()){
            // Create the new category
            $formfield= $validator->validated();
            $category=$agent->createCategories($formfield);

            // Return a success JSON response.
            // You can include the newly created category data if the frontend needs it.
            return response()->json([
                'success' => true,
                'message' => 'Category added successfully!',
                'category' => $category,
            ], 201); // 201 Created

        } 
    }



    public function edit($id)
    {
        $category= Category::find($id);
        // dd($category);

        return response()->json($category);
    }

    public function update(Request $request, $id){
        $validator=Validator::make($request->all(),
                    ['name' => 'required|string|max:255|unique:categories,name,']);

        // $request->validate(['name' => 'required|string|max:255|unique:categories,name,'.$category->id]);
        $category= Category::find($id);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
        if($validator->passes()){

            if($category!=null){
                $formfield= $validator->validated();
                $category->update($formfield);

                    return response()->json([
                    'success' => true,
                    'message' => 'Category updated successfully.',
                    'category' => $category->fresh()   // optional: send fresh timestamps
                ]);
            }
           
        }
        
    }


    public function destroy(Category $category){
   
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
            ], 200); // 200 OK is appropriate when returning a message

        

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the category.'
            ], 500); // 500 Internal Server Error
    }


}
