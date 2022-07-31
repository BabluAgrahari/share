<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\client;
use App\Models\ContactPerson;
use App\Models\Company;
use App\Models\TransferAgent;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        $data['lists'] = Client::all();
        return view('client.index', $data);
    }

    public function create(Request $request)
    {
        $data['companies']= Company::get();
        $data['agents']= TransferAgent::get();
        $data['contacts']= ContactPerson::get();
        return view('client.create',$data);
    }

    public function store(ClientRequest $request)
    {
        $store = new Client;
        $store->contact_person   =$request->contact_person;
        $store->agent_name   =$request->agent_id;
        $store->company_name   =$request->company_id;
        $store->file_no         = $request->file_no;
        $store->share_holder    = $request->share_holder;
        $store->surivor_name    = $request->surivor_name;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;

        // echo "<pre>";
        // print_r($request->all());die;
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
        $data['companies']= Company::get();
        $data['agents']= TransferAgent::get();
        $data['res'] = Client::find($id);
        $data['contacts']= ContactPerson::get();
        return view('client.edit', $data);
    }

    public function update(ClientRequest $request, $id)
    {
        $update =  Client::find($id);
        $update->contact_person =$request->contact_person;
        $update->agent_name   =$request->agent_id;
        $update->company_name   =$request->company_id;
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
