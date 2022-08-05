<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Company;
use App\Models\client;

class CourtController extends Controller
{

    public function index()
    {
        $data['lists'] = Court::all();
        return view('court.index', $data);
    }


    public function create()
    {

        return view('court.create');
    }


    public function store(Request $request)
    {
        $store = new Court;
        $store->court_name         = $request->court_name;
        $store->city               = $request->city;
        $store->state              = $request->state;
        $store->pin                = $request->pin;
        $store->address            = $request->address;
        $store->cp_name            = $request->cp_name;
        $store->cp_email           = $request->cp_email;
        $store->cp_phone           = $request->cp_phone;

        if ($store->save()) {

            $this->storeContactPerson(request: $request, ref_id: $store->id, ref_by: 'court'); //for insert record into contact_person table

            return redirect()->back()->with('success', 'Court Created Successfully');
        }
        return redirect()->back()->with('error', 'Court not Created');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data['res'] = Court::find($id);
        return view('court.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $update = Court::find($id);
        $update->court_name         = $request->court_name;
        $update->city               = $request->city;
        $update->state              = $request->state;
        $update->pin                = $request->pin;
        $update->address            = $request->address;
        $update->cp_name            = $request->cp_name;
        $update->cp_email           = $request->cp_email;
        $update->cp_phone           = $request->cp_phone;


        if ($update->save()) {

            $this->updateContactPerson(request: $request, ref_id: $id, ref_by: 'court'); //for update record into contact_person table

            return redirect()->back()->with('success', 'Court Created Successfully');
        }
        return redirect()->back()->with('error', 'Court not Created');
    }


    public function delete($id)
    {
        $det = Court::find($id)->delete();
        if ($det) {
            return redirect('court');
        }
    }
}
