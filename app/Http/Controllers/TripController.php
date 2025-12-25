<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Hotel;
use App\Models\Category;
use App\Models\Destination;
use App\Models\TravelAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class TripController extends Controller
{
    
    private $user_id;
    private $agent;

    public function __construct() {
        $this->user_id=Auth::user()->id ?? null;
        $this->agent= TravelAgent::find($this->user_id);
    }


    //home page
    public function index(){
               
        $max_duration= Trip::max('duration');
        $min_duration= Trip::min('duration');
        $max_price= Trip::max('price'); 
        $min_price= Trip::min('price');
        $trips= Trip::latest()->filter(request(['search']))->get();
        return view('trips.index',[ 'trips'=>$trips,
                                    'categories'=>Category::all(),
                                    'max_duration'=>$max_duration, 'min_duration'=>$min_duration,
                                    'max_price'=>$max_price,'min_price'=>$min_price
                                    ]);
    }


    // to filter trips based on criteria
    public function filter(Request $request){
        // dd($request->all());
        $query= Trip::query();

        if($request->has('categories')&& !empty($request->categories)){
            $query->whereIn('category_id',$request->categories);
        }
        if($request->has('destination_id')&& !empty($request->destination_id)){
            $query->where('destination_id',$request->destination_id);
            
        }
        if($request->has('duration_min')&& !empty($request->duration_min)){
            $query->where('duration','>=',$request->duration_min);
            
        }

         if($request->has('duration_max')&& !empty($request->duration_max)){
            $query->where('duration','<=',$request->duration_max);
            
        }

        if($request->has('price_min')&& !empty($request->price_min)){
            $query->where('price','>=',$request->price_min);
            
        }
         if($request->has('price_max')&& !empty($request->price_max)){
            $query->where('price','<=',$request->price_max);
         
        }

        $trips= $query->get();
        // dd($trips);

        $html= view('partials._card',compact('trips'))->render();
        
        return response()->json([
                        'html'=>$html]);

    }


    // show trip-form
    public function create(){
        return view('trips.create',['places'=>Destination::all(),'categories'=>Category::all()]);
    }


    // store new trip
    public function store(Request $request){
        $formfield= $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'price'=>'required',
            'destination_id'=>'required',
            'duration'=>'required',
            'date'=>'required',
            'description'=>'required',
        ]);

        $trip= $this->agent->createPackage($formfield);
        // Trip::create($formfield);
        return redirect()->action([TripController::class,'assign'],$trip)->with('message','Assign your hotel');
        // return redirect("/trip/manage/")->with('message',"trip added");
        
    }


    // show(view) details 
    public function show($id){    
        $trip_hotel= Trip::with(['hotel'])->find($id);

        return view('trips.show',['trip'=>$trip_hotel]);
    }


    //agent's
    // shows trip form to update
    public function update(Trip $trip){

        return view('trips.update',['trip'=>$trip,'destinations'=>Destination::where('title','!=',$trip->destination->title)->get(),'categories'=>Category::all()]);
    }

    // update trip info..
    public function edit(Request $request,$id){
        $formfield= $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'price'=>'required',
            'destination_id'=>'required',
            'duration'=>'required',
            'date'=>'required',
            'description'=>'required',
        ]);

        $this->agent->updatePackage($formfield,$id);

        return redirect("/trip/manage/")->with('message',"Trip updated")->with('color','secondary');

    }

    // delete trip info
    public function destroy(Trip $trip){
        $this->agent->deletePackage($trip);
        return redirect('/trip/manage/')->with('message',"trip deleted")->with('color','danger');
    }
    // agent's
 
    // return json
    public function returnLists($id){
        $trip_hotel= Trip::with(['hotel.reservation'])->find($id);
        return response()->json([
            'triphotel'=>$trip_hotel->hotel,
            'response'=>'success']);
    }


    // show Trips in table(managing)
    public function manage(){
        return view('trips.manage',['trips'=>Trip::latest()->filter(request(['search']))->get()]);
        
    }

    // assign hotel for each trip (shows a lists of hotel based on their destinations)
    public function assign(Trip $trip){
        
        $destination= $trip->destination_id;
        $hotel= Hotel::where('destination_id',$destination)->get();

        return view('trips.assign',['trip'=>$trip,'hotels'=>$hotel]);
    }

    // to assign(store) each trip to hotel
    public function assignStore(Request $request){

        
            $formfield= $request->validate([
                'trip_id'=>'required',
                'hotel_id'=>'required',
            ]);

            // insert data to pivot table
           foreach ($formfield['hotel_id'] as $value) {
                $this->agent->AssignHotel($request['trip_id'],$value);
                // $trip->hotel()->attach($value);

           }
           return redirect()->action([TripController::class,'manage'])->with('message','hotel assigned!');
        //    return back()->with('message','hotel assigned!');


    }


    // to delte(remove) hotels from each trip
    public function assignDelete(Trip $trip){

        $this->agent->RemoveHotel($trip);
        // $trip->hotel()->detach();
        // $trip->setStatus('not_available');
        return back()->with('message','assigned hotels removed!!');

    }




}
