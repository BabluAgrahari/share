<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\ContactPerson;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function index()
    {
        $data['lists'] = Company::all();
        return view('company.index', $data);
    }

    public function create(Request $request)
    {
        $data['contacts'] = ContactPerson::get();
        return view('company.create', $data);
    }

    public function store(CompanyRequest $request)
    {
        $store = new Company;
        $store->contact_person_id   = $request->contact_person_id;
        $store->company_name     = $request->company_name;
        $store->phone            = $request->phone;
        $store->email            = $request->email;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;

        // echo "<pre>";
        // print_r($request->all());die;
        if ($store->save()) {
            return redirect()->back()->with('success', 'company Created Successfully');
        }
        return redirect()->back()->with('error', 'company not Created');
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $data['res'] = Company::find($id);
        $data['contacts'] = ContactPerson::get();
        return view('company.edit', $data);
    }

    public function update(CompanyRequest $request, $id)
    {
        $update =  Company::find($id);
        $update->contact_person_id   = $request->contact_person_id;
        $update->company_name     = $request->company_name;
        $update->phone            = $request->phone;
        $update->email            = $request->email;
        $update->address         = $request->address;
        $update->city            = $request->city;
        $update->state           = $request->state;
        $update->pin             = $request->pin;

        if ($update->save()) {
            return redirect('/company')->with('success', 'Company Update successfully');
        }
        return redirect()->back()->with('error', 'Company not Update');
    }

    public function delete($id)
    {
        $res = Company::find($id)->delete();

        if ($res) {
            return redirect()->back()->with('success', 'Company Removed Successfully');
        }
        return redirect()->back()->with('error', 'Company not Removed');
    }
}