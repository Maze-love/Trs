<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Parental\HasChildren;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasChildren;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password','type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // overrides raw class names of databases
    protected $childTypes=[
        'Admin'=>Admin::class,
        'Customer'=>Customer::class,
        'Manager'=>Manager::class,
        'Travel_agent'=>TravelAgent::class
    ];

    // a user login and logout first
    public function login($data){
        // dd($data);
        if (Auth::attempt($data)) return true;
        else return false;
    }
    public function leave(){
        Auth::logout();
    }
    // accessing their role
    public function getRole(){
        return $this->attributes['type'];
    }
}
