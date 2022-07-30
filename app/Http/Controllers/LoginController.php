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


    public function register()
    {
        return view('register');
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'firstname' => 'required',
                'lastname' => 'required',
                'father_name' => 'required',
                'add' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
                'password' => 'min:6 |required'
            ],

            [
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
                'father_name.required' => 'Father Name is required',
                'add.required' => 'Address is required',
                'mobile.required' => 'Phone Number is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required'
            ],


        );

        $store = new User();
        $store->firstname           = $request->firstname;
        $store->lastname            = $request->lastname;
        $store->father_name         = $request->father_name;
        $store->add                 = $request->add;
        $store->mobile              = $request->mobile;
        $store->email               = $request->email;
        $store->password            = Hash::make($request->password);

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('ymdhi') . $file->getClientOriginalName();
            $file->move(public_path('/image'), $filename);
            $store->image    = $filename;

            if ($store->save()) {
                return redirect('/')->with('success', 'Data Insert Successfully');
            }
            return redirect('/')->with('error', 'Data Not Insert ');
        }
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


    public function dashboard()
    {

        // check if user logged in
        if (Auth::check()) {
            return redirect('home')->withErrors('success', 'You Login');
        }

        return redirect('/')->withSuccess('Oopps! You do not have access');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }


    public function home()
    {
        return view('home');
    }

    public function destroy($id)
    {
        //
    }
}
