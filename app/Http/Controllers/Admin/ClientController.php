<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        $data['lists'] = Client::all();
        return view('client.index', $data);
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(ClientRequest $request)
    {
        $store = new Client;
        $store->file_no         = $request->file_no;
        $store->share_holder    = $request->share_holder;
        $store->surivor_name    = $request->surivor_name;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;

        if ($store->save()) {
            return redirect()->back()->with('success', 'Client Created Successfully');
        }
        return redirect()->back()->with('error', 'Client not Created');
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $data['res'] = Client::find($id);
        return view('client.edit', $data);
    }

    public function update(ClientRequest $request, $id)
    {
        $update =  Client::find($id);
        $update->file_no       = $request->file_no;
        $update->share_holder  = $request->share_holder;
        $update->surivor_name  = $request->surivor_name;
        $update->address       = $request->address;
        $update->city          = $request->city;
        $update->state         = $request->state;
        $update->pin           = $request->pin;
        // $update->contact_person_name     = $request->contact_person_name;
        // $update->mobile                  = $request->mobile;
        // $update->email                   = $request->email;

        if ($update->save()) {
            return redirect('/client')->with('success', 'Client Update successfully');
        }
        return redirect()->back()->with('error', 'Client not Update');
    }

    public function delete($id)
    {
        $res = Client::find($id)->delete();

        if ($res) {
            return redirect()->back()->with('success', 'Client Removed Successfully');
        }
        return redirect()->back()->with('error', 'Client not Removed');
    }
}
