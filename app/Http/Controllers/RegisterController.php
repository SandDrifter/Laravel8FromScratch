<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create(){   
        return view('register.create'); 
    }   

     public function store(){   
        // create the user
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            //'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255',
            //'password' => ['required', 'min:7', 'max:255'] //same as above
        ]);

      //  $attributes['password'] = bcrypt($attributes['password']);
        $user = User::create($attributes);

        //log user in
        auth()->login($user);

        //session()->flash('success', 'Your account has been created.');
        
        // with(...) same as //session()->flash('...');
        return redirect('/')->with('success', 'Your account has been created.'); 
    }
}
