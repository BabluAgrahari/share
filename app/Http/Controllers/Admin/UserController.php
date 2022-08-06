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
    public function index(Request $request)
    {
        $query = User::query();

        if (!empty($request->name))
            $query->where('name', $request->name);

        if (!empty($request->email))
            $query->where('email', $request->email);

        if (!empty($request->phone))
            $query->where('phone', $request->phone);

        if (!empty($request->status))
            $query->where('status', $request->status);

        if (!empty($request->date_range)) {
            list($start_date, $end_date) = explode('-', $request->date_range);
            $start_date = strtotime(trim($start_date) . " 00:00:00");
            $end_date   = strtotime(trim($end_date) . " 23:59:59");
        } else {
            $start_date = $this->start_date;
            $end_date   = $this->end_date;
        }

        $query->whereBetween('created', [$start_date, $end_date]);

        $data['lists'] = $query->orderBy('created', 'DESC')->paginate($this->perPage);

        $request->request->remove('page');
        $request->request->remove('perPage');
        $data['filter']  = $request->all();
        return view('user.index', $data);
    }


    public function create()
    {
        return view('user.create');
    }


    public function store(UserRequest $request)
    {
        $store = new User();
        $store->name                = $request->name;
        $store->role                = $request->role;
        $store->city                = $request->city;
        $store->state               = $request->state;
        $store->pin                 = $request->pin;
        $store->address             = $request->address;
        $store->mobile              = $request->mobile;
        $store->email               = $request->email;
        $store->status               = $request->status;
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


    public function update(UserRequest $request, $id)
    {

        $update =  User::find($id);
        $update->name                = $request->name;
        $update->role                = $request->role;
        $update->city                = $request->city;
        $update->status              = $request->status;
        $update->address             = $request->address;
        $update->mobile              = $request->mobile;
        $update->email               = $request->email;
        $update->status              = $request->status;
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
