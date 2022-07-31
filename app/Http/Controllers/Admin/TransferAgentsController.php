<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferAgentsRequest;
use App\Models\TransferAgent;
use App\Models\ContactPerson;
use Illuminate\Http\Request;

class TransferAgentsController extends Controller
{
    public function index()
    {
        $data['lists'] = TransferAgent::all();
        return view('transfer_agent.index', $data);
    }

    public function create(Request $request)
    {
        $data['contacts']= ContactPerson::get();
        return view('transfer_agent.create',$data);
    }

    public function store(TransferAgentsRequest $request)
    {
        $store = new TransferAgent;
        $store->contact_person   =$request->contact_person;
        $store->agency_name     = $request->agency_name;
        $store->phone            = $request->phone;
        $store->email            = $request->email;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;

        // echo "<pre>";
        // print_r($request->all());die;
        if ($store->save()) {
            return redirect()->back()->with('success', 'Transfer Agent Created Successfully');
        }
        return redirect()->back()->with('error', 'Transfer Agent not Created');
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $data['res'] = TransferAgent::find($id);
        $data['contacts']= ContactPerson::get();
        return view('transfer_agent.edit', $data);
    }

    public function update(TransferAgentsRequest $request, $id)
    {
        $update =  TransferAgent::find($id);
        $update->contact_person   =$request->contact_person;
        $update->agency_name     = $request->agency_name;
        $update->phone            = $request->phone;
        $update->email            = $request->email;
        $update->address         = $request->address;
        $update->city            = $request->city;
        $update->state           = $request->state;
        $update->pin             = $request->pin;
        // $update->contact_person_name     = $request->contact_person_name;
        // $update->mobile                  = $request->mobile;
        // $update->email                   = $request->email;

        if ($update->save()) {
            return redirect('/transfer_agent')->with('success', 'Transfer Agent Update successfully');
        }
        return redirect()->back()->with('error', 'Transfer Agent not Update');
    }

    public function delete($id)
    {
        $res = TransferAgent::find($id)->delete();

        if ($res) {
            return redirect()->back()->with('success', 'Transfer Agent Removed Successfully');
        }
        return redirect()->back()->with('error', 'Transfer Agent not Removed');
    }
}
