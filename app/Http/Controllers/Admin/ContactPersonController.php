<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\ContactPerson;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
{

    public function index()
    {
        $data['lists'] = ContactPerson::all();
        return view('contact.index', $data);
    }

    public function create(Request $request)
    {

        return view('contact.create');
    }

    public function store(Request $request)
    {
        $store = new ContactPerson;
        $store->name         = $request->name;
        $store->mobile        = $request->mobile;
        $store->email        = $request->email;
        $store->status       = $request->status;

        if ($store->save()) {
            return redirect()->back()->with('success', 'contact Created Successfully');
        }
        return redirect()->back()->with('error', 'contact not Created');
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
        // $update->contact_person_name     = $request->contact_person_name;
        // $update->mobile                  = $request->mobile;
        // $update->email                   = $request->email;

        if ($update->save()) {
            return redirect('/contact')->with('success', 'contact Update successfully');
        }
        return redirect()->back()->with('error', 'contact not Update');
    }

    public function delete($id)
    {
        $res = ContactPerson::find($id)->delete();

        if ($res) {
            return redirect()->back()->with('success', 'contact Removed Successfully');
        }
        return redirect()->back()->with('error', 'contact not Removed');
    }
}
