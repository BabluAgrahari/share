<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }


    public function show(Request $request)
    {

        $request->validate(
            [
                'email'  => 'required',
                'password' => 'required'
            ],

            [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required'

            ],
        );

        if (Auth::attempt($request->only('email', 'password'))) {

            return redirect('home');
        }
        return redirect('/')->with('error', 'Login Details Is Not Valide');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
