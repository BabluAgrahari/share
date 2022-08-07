<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferAgentsRequest;
use App\Models\Company;
use App\Models\TransferAgent;
use App\Models\ContactPerson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferAgentsController extends Controller
{
    public function index(Request $request)
    {
        $query = TransferAgent::query();

        if (!empty($request->transfer_agent))
            $query->where('transfer_agent', 'LIKE', "%$request->transfer_agent%");

        if (!empty($request->email))
            $query->where('email', $request->email);

        if (!empty($request->phone))
            $query->where('phone', $request->phone);

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

        return view('transfer_agent.index', $data);
    }

    public function create(Request $request)
    {
        $data['companies'] = Company::select('id', 'company_name')->get();
        return view('transfer_agent.create', $data);
    }

    public function store(TransferAgentsRequest $request)
    {
        $store = new TransferAgent;
        $store->user_id         = Auth::user()->id;
        $store->transfer_agent   = $request->transfer_agent;
        $store->phone           = $request->phone;
        $store->email           = $request->email;
        $store->address         = $request->address;
        $store->city            = $request->city;
        $store->state           = $request->state;
        $store->pin             = $request->pin;
        $store->company_id      = (!empty($request->company_id) && is_array($request->company_id)) ? implode(',', $request->company_id) : '';
        $store->cp_name         = $request->cp_name;
        $store->cp_email        = $request->cp_email;
        $store->cp_phone        = $request->cp_phone;
        $store->cp_designation  = $request->cp_designation;
        $store->remarks         = $request->remarks;

        if ($store->save()) {

            $this->storeContactPerson(request: $request, ref_id: $store->id, ref_by: 'agent'); //for insert record into contact_person table

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
        $data['companies'] = Company::select('id', 'company_name')->get();
        return view('transfer_agent.edit', $data);
    }

    public function update(TransferAgentsRequest $request, $id)
    {
        $update =  TransferAgent::find($id);
        $update->cp_id           = $request->cp_id;
        $update->transfer_agent   = $request->transfer_agent;
        $update->phone           = $request->phone;
        $update->email           = $request->email;
        $update->address         = $request->address;
        $update->city            = $request->city;
        $update->state           = $request->state;
        $update->pin             = $request->pin;
        $update->company_id      = (!empty($request->company_id) && is_array($request->company_id)) ? implode(',', $request->company_id) : '';
        $update->cp_name         = $request->cp_name;
        $update->cp_email        = $request->cp_email;
        $update->cp_phone        = $request->cp_phone;
        $update->cp_designation  = $request->cp_designation;
        $update->remarks         = $request->remarks;

        if ($update->save()) {

            $this->updateContactPerson(request: $request, ref_id: $id, ref_by: 'agent'); //for update record into contact_person table

            return redirect('/transfer-agent')->with('success', 'Transfer Agent Update successfully');
        }
        return redirect()->back()->with('error', 'Transfer Agent not Update');
    }

    public function status(Request $request)
    {
        try {
            $save = TransferAgent::find($request->id);
            $save->status = (int)$request->status;
            $save->save();
            if ($save->status == 1)
                return response(['status' => 'success', 'msg' => 'This Agent is Active!', 'val' => $save->status]);

            return response(['status' => 'success', 'msg' => 'This Agent is Inactive!', 'val' => $save->status]);
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Something went wrong!!']);
        }
    }

}
