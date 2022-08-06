<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\ContactPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->name)
            $query->where('company_name', 'LIKE', "%$request->name%");

        if (!empty($request->email))
            $query->where('email', $request->email);

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
        $store->user_id         = Auth::user()->id;
        $store->cp_id   = $request->cp_id;
        $store->company_name     = $request->company_name;
        $store->phone            = $request->phone;
        $store->email            = $request->email;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;
        $store->cp_name         = $request->cp_name;
        $store->cp_email         = $request->cp_email;
        $store->cp_phone         = $request->cp_phone;
        $store->remarks         = $request->remarks;

        // echo "<pre>";
        // print_r($request->all());die;
        if ($store->save()) {

            $this->storeContactPerson(request: $request, ref_id: $store->id, ref_by: 'company'); //for insert record into contact_person table

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
        $update->cp_id   = $request->cp_id;
        $update->company_name     = $request->company_name;
        $update->phone            = $request->phone;
        $update->email            = $request->email;
        $update->address         = $request->address;
        $update->city            = $request->city;
        $update->state           = $request->state;
        $update->pin             = $request->pin;
        $update->cp_name         = $request->cp_name;
        $update->cp_email         = $request->cp_email;
        $update->cp_phone         = $request->cp_phone;
        $update->remarks         = $request->remarks;

        if ($update->save()) {

            $this->updateContactPerson(request: $request, ref_id: $id, ref_by: 'company'); //for update record into contact_person table

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
