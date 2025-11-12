<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    //
    public function showLogin(){
        return view('login');
    }
    
    public function showRegister(){
        return view('register');
    }


    //create new user
    public function register(Request $request){
        // dd($request->all());
        $formFields= $request->validate([
            'name'=>['required','min:3'],
            'username'=>'required',
            'email'=>['required','email', Rule::unique('users','email')],
            'password'=>'required|confirmed',
           
        ]);
       
        $newUser= new Customer();
        $newUser->create($formFields);
        return redirect("/login")->with("message","U have been Registered, login to continue.. ");
    
    }


    public function login(Request $request){
        // dd($request->all());
        $formFields= $request->validate([
            'email'=>['required','email'],
            'password'=>'required',
        ]);
        
        $user= new User();
        $email= $formFields['email'];
        $user= $user->where('email',$email)->first();
        
        if ($user->login($formFields)){

            $request->session()->regenerate();
            if($user->type=='Travel_agent'){
                return redirect()->action([])->with("message","welcome "."$user->type");
            }
            else if ($user->type=='Manager'){
                return redirect()->action([HotelController::class,'index'])->with("message","welcome "."$user->type");

            }
            else if ($user->type=='Admin'){
                return redirect()->action([])->with("message","welcome "."$user->type");

            }
            else if ($user->type=='Customer'){
                return redirect()->action([])->with("message","welcome "."$user->type");

            }

        }
    
        
        return back()->withErrors([
            'password'=> 'invalid credentials'
        ])->withInput();

    }
    


    public function Logout(Request $request){
        $user= new User();

        $user->leave();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('message',"you are logout!!");

    }
}
