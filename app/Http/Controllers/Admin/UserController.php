<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        
        return view('user.login');
    }

    public function list()
    {
         $data['lists'] = User::all();
        return view('user.index',$data);
    }


    public function create()
    {
        return view('user.create');
    }


    public function store(Request $request)
    {
        // $request->validate(
        //     [
        //         'name' => 'required',
        //         'city' => 'required',
        //         'state' => 'required',
        //         'pin' => 'required',
        //         'address' => 'required',
        //         'mobile' => 'required',
        //         'email' => 'required|email',
        //         'password' => 'min:6 |required'
        //     ],

        //     [
        //         'name.required' => 'Name is required',
        //         'city.required' => 'City is required',
        //         'state.required' => 'State is required',
        //         'pin.required' => 'PIn is required',
        //         'address.required' => 'Address is required',
        //         'mobile.required' => 'Phone Number is required',
        //         'email.required' => 'Email is required',
        //         'password.required' => 'Password is required'
        //     ],


        // );

        $store = new User();
        $store->name           = $request->name;
        $store->city            = $request->city;
        $store->state         = $request->state;
        $store->pin                 = $request->pin;
        $store->address                 = $request->address;
        $store->mobile              = $request->mobile;
        $store->email               = $request->email;
        $store->password            = Hash::make($request->password);
        if ($store->save()) {
            return redirect('list')->with('success', 'Data Insert Successfully');
        }
        return redirect('create')->with('error', 'Data Not Insert ');
    }


    public function edit($id)
    {
        $data['res'] =User::find($id);
        return view('user.edit',$data);
    }


    public function update(Request $request)
    {

        $update =  User::find($request->id);
        $update->name           = $request->name;
        $update->city            = $request->city;
        $update->state         = $request->state;
        $update->pin                 = $request->pin;
        $update->address                 = $request->address;
        $update->mobile              = $request->mobile;
        $update->email               = $request->email;
        $update->password            = Hash::make($request->password);
        
        if ($update->save()) {
            return redirect('list')->with('success', 'Data Insert Successfully');
        }
        return redirect("edit{id}")->with('error', 'Data Not Insert ');
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
        return view('dashboard');
    }


    public function delete($id)
    {
        $det = User::get($id)->delete();
        if($det)
        {
            return redirect('list');
        }
    }
}
