<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
    //manages reservations 

class ReservationController extends Controller
{

// Trip/Hotel Reservation section
      // reserve trip & hotel (user's)
    public function reserve(Request $request){
        $user_id= Auth::user()->id;

        $formdata= $request->validate([
            // 'status'=>'required',
            'hotel_id'=>'required',
            'trip_id'=>'required'
        ]);
        $customer= Customer::find($user_id);
        // already existing reservation;
        $reservation_exists=Reservation::where('trip_id',$formdata['trip_id'])
                    ->where('hotel_id',$formdata['hotel_id'])
                    ->where('user_id',$user_id)->first();

        // holds whether a trip's single hotel reserved or not.
        $oneReservation= Reservation::where('user_id',$user_id)
                            ->where('trip_id',$formdata['trip_id'])->exists();

        if (!$reservation_exists){

            if(!$oneReservation){

                $customer->bookTripHotel($formdata);

                return redirect('/reserve/show')
                ->with('message',"Reservation made wait until it is confirmed!")
                ->with('color','secondary');
            }

           
        }
            return back()
            ->with('message','Reservation already exists')
            ->with('color','danger');
        // return view('hotel.reserve');
    }

    // agent's
    public function showAllReservation(){
        $reservation= Reservation::get();
        return view('trips.reservation',['data'=>$reservation]);
        
    }

    // user's
    // shows user's all reservation
    public function showUserReservation(){
        $user_id= Auth::user()->id;
        $customer_reservation= Customer::find($user_id)->getReservation();
        // dd($reservation);
        return view('users.myreservations',['data'=>$customer_reservation]);

    }
    
    //user's
    // shows detail reservation
    public function manageUserReservation($id){
        $user_id= Auth::user()->id;
        $reservation_detail= Customer::find($user_id)->getReservation($id);
        return view('users.detail',[
            'data'=>$reservation_detail
        ]);

    }

    // user's
    public function updateReservation(Request $request){
        $user_id= Auth::user()->id;

        $res= Reservation::find($request['reservation_id']);
        // dd($request->all());
        if($request['cancel']){
            
            $res->delete();
        }
        return redirect("/reserve/show")->with('message','reservation deleted!!');


    }

    public function filterUserReservations(Request $request)
    {
        $statuses = $request->input('statuses', []);
        $userId = Auth::user()->id;

        $query = Reservation::where('user_id', $userId)->with(['trip', 'hotel.destination', 'booking']);

        if (!empty($statuses)) {
            $query->where(function ($q) use ($statuses) {
                if (in_array('upcoming', $statuses)) {
                    $q->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'confirmed')
                                 ->whereHas('booking', function ($bookingQuery) {
                                     $bookingQuery->where('status', '!=', 'confirm');
                                 });
                    });
                }
                if (in_array('completed', $statuses)) {
                    $q->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'confirmed')
                                 ->whereHas('booking', function ($bookingQuery) {
                                     $bookingQuery->where('status', 'confirm');
                                 });
                    });
                }
                if (in_array('cancelled', $statuses)) { // This corresponds to "book your stay"
                    $q->orWhere(function ($subQuery) {
                        $subQuery->where('status', 'confirmed')
                                 ->whereDoesntHave('booking');
                    });
                }
            });
        }

        $reservations = $query->latest()->get();

        // As you requested, we render a partial view and return the HTML
        return view('partials._reservation_timeline', ['data' => $reservations])->render();
    }

    // agent's
    public function ManageReservation($id,Request $request){
        $res= Reservation::find($id);

        if($request['cancel']){
            $res->update([
                'status'=>'cancelled'
            ]);
        }
        elseif($request['confirm']){
            $res->update([
                'status'=>'confirmed'
            ]);
        }
        else if ($request['pend']){
            $res->update([
                'status'=>'pending'
            ]);
        }
        else{
            $res->delete();
                $res->update([
                    'status'=>'cancelled'
            ]);
         return back()->with('message','order deleted!!');

        }
        
        return back()->with('message','status changed!!');

    }

    
    //Hotel Booking section

    
   

}
