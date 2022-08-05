<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\UserProvider;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

  

    public function index()
    {
        $data['lists'] = User::all();
        return view('user.index', $data);
    }


    public function create()
    {
        return view('user.create');
    }


    public function store(UserRequest $request)
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
        $store->role           = $request->role;
        $store->city           = $request->city;
        $store->state          = $request->state;
        $store->pin                 = $request->pin;
        $store->address                 = $request->address;
        $store->mobile              = $request->mobile;
        $store->email               = $request->email;
        $store->password            = Hash::make($request->password);
        if ($store->save()) {
            return redirect('user')->with('success', 'Data Insert Successfully');
        }
        return redirect()->back()->with('error', 'Data Not Insert ');
    }


    public function edit($id)
    {
        $data['res'] = User::find($id);
        return view('user.edit', $data);
    }


    public function update(UserRequest $request ,$id)
    {

        $update =  User::find($id);
        $update->name           = $request->name;
        $update->role           = $request->role;
        $update->city            = $request->city;
        $update->state         = $request->state;
        $update->pin                 = $request->pin;
        $update->address                 = $request->address;
        $update->mobile              = $request->mobile;
        $update->email               = $request->email;
        $update->password            = Hash::make($request->password);

        if ($update->save()) {
            return redirect('user')->with('success', 'Data Insert Successfully');
        }
        return redirect()->back()->with('error', 'Data Not Insert ');
    }



   

   


    public function home()
    {
        return view('dashboard');
    }


    public function delete($id)
    {
        $det = User::get($id)->delete();
        if ($det) {
            return redirect('user');
        }
    }
}
