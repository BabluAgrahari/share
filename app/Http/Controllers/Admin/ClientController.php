<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientToCompany;
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
        $store->file_no         = $request->file_no;
        $store->share_holder    = $request->share_holder;
        $store->survivor_name   = $request->survivor_name;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;
        $store->remarks         = $request->remarks;
        $store->cp_name         = $request->cp_name;
        $store->cp_email        = $request->cp_email;
        $store->cp_phone        = $request->cp_mobile;

        if ($store->save()) {

            self::clientToCompany($request->company, $store->id, 'store'); //insert record into client_to_company table

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

        $data['res'] = Client::find($id);

        $data['client_to_company'] = ClientToCompany::where('client_id', $id)->get();
        return view('client.edit', $data);
    }

    public function update(ClientRequest $request, $id)
    {
        $update =  Client::find($id);
        $update->file_no         = $request->file_no;
        $update->share_holder    = $request->share_holder;
        $update->survivor_name   = $request->survivor_name;
        $update->address         = $request->address;
        $update->city            = $request->city;
        $update->state           = $request->state;
        $update->pin             = $request->pin;
        $update->remarks         = $request->remarks;
        $update->cp_name         = $request->cp_name;
        $update->cp_email        = $request->cp_email;
        $update->cp_phone        = $request->cp_mobile;

        if ($update->save()) {

            self::clientToCompany($request->company, $update->id, 'update'); //insert record into client_to_company table

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


    private function clientToCompany($requests = array(), $client_id = false, $type = 'store')
    {
        if (empty($requests) || !$client_id)
            return false;

        if ($type != 'store')
            clientToCompany::where('client_id', $client_id)->delete();

        foreach ($requests as $request) {

            $request = (object)$request;

            $save = new ClientToCompany();
            $save->client_id = $client_id;
            $save->company_id = $request->company_id;
            $save->unit = $request->unit;
            $save->agent_id = $request->agent_id;
            $save->save();
        }
    }

    public function findClient($id = false)
    {
        if (!$id)
            return false;

        $results = TransferAgent::where('company_id', $id)->get();

        $option = '<option value="">Select</option>';
        foreach ($results as $res) {
            $option .= '<option value="' . $res->id . '">' . ucwords($res->agency_name) . '</option>';
        }

        die(json_encode($option));
    }
}
