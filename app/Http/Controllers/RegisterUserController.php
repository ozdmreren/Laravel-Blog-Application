<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(){
        $attributes = request()->validate([
            'first_name'=>['required','string'],
            'last_name'=>['required','string'],
            'email'=>['required','email','max:255','unique:users'],
            'password'=>['required',Password::min(6),'confirmed']
        ]);

        $user = User::create([
            'first_name'=>request('first_name'),
            'last_name'=>request('last_name'),
            'email'=>request('email'),
            'avatar'=>"logo.jpg",
            'bio'=>'Hello i am '.request('first_name').' and i am new',
            'password'=>Hash::make(request('password'))
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect('/');
    }
}
