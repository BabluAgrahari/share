<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\client;
use App\Models\ContactPerson;
use App\Models\Company;
use App\Models\TransferAgent;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index(Request $request)
    {

        $data['lists'] = Client::all();
        return view('client.index', $data);
    }

    public function create(Request $request)
    {
        $data['companies'] = Company::select('id', 'company_name')->get();
        $data['agents']    = TransferAgent::select('id', 'agency_name')->get();
        $data['contacts']  = ContactPerson::select('id', 'name')->get();

        return view('client.create', $data);
    }

    public function store(ClientRequest $request)
    {
        $store = new Client;
        $store->contact_person_id   = $request->contact_person_id;
        $store->agent_id       = $request->agent_id;
        $store->company_id     = $request->company_id;
        $store->file_no         = $request->file_no;
        $store->share_holder    = $request->share_holder;
        $store->survivor_name    = $request->survivor_name;
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
        $data['companies'] = Company::select('id', 'company_name')->get();
        $data['agents']    = TransferAgent::select('id', 'agency_name')->get();
        $data['contacts']  = ContactPerson::select('id', 'name')->get();

        $data['res'] = Client::find($id);
        return view('client.edit', $data);
    }

    public function update(ClientRequest $request, $id)
    {
        $update =  Client::find($id);
        $update->contact_person_id = $request->contact_person_id;
        $update->agent_id   = $request->agent_id;
        $update->company_id   = $request->company_id;
        $update->file_no       = $request->file_no;
        $update->share_holder  = $request->share_holder;
        $update->survivor_name  = $request->survivor_name;
        $update->address       = $request->address;
        $update->city          = $request->city;
        $update->state         = $request->state;
        $update->pin           = $request->pin;

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


    public function findClient($id = false)
    {
        if (!$id)
            return false;

        $results = TransferAgent::where('campany_name', $id)->get();

        $option = '<option value="">Select</option>';
        foreach ($results as $res) {
            $option .= '<option value="' . $res->id . '">' . ucwords($res->agency_name) . '</option>';
        }

        die($option);
    }
}
