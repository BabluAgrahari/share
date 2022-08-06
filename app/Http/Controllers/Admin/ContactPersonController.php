<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\ContactPerson;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactPersonController extends Controller
{

    public function index()
    {
        $data['lists'] = ContactPerson::paginate($this->perPage);
        return view('contact.index', $data);
    }

    public function create(Request $request)
    {

        return view('contact.create');
    }

    public function store(Request $request)
    {
        $store = new ContactPerson;
        $store->user_id         = Auth::user()->id;
        $store->name         = $request->name;
        $store->mobile        = $request->mobile;
        $store->email        = $request->email;
        $store->status       = $request->status;

        if ($store->save()) {
            return redirect()->back()->with('success', 'Contact Person Created Successfully');
        }
        return redirect()->back()->with('error', 'Contact Person not Created');
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $data['res'] = ContactPerson::find($id);
        return view('contact.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $update =  ContactPerson::find($id);
        $update->name         = $request->name;
        $update->mobile        = $request->mobile;
        $update->email        = $request->email;
        $update->status       = $request->status;

        if ($update->save()) {
            return redirect('/contact')->with('success', 'Contact Person  Update successfully');
        }
        return redirect()->back()->with('error', 'Contact Person not Update');
    }

    public function delete($id)
    {
        $res = ContactPerson::find($id)->delete();

        if ($res) {
            return redirect()->back()->with('success', 'Contact Person Removed Successfully');
        }
        return redirect()->back()->with('error', 'Contact Person not Removed');
    }
}
