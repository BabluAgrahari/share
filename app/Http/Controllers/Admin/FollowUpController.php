<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourtRequest;
use App\Models\Client;
use App\Models\ClientToCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\FollowUpClient;
use Illuminate\Support\Facades\Auth;

class FollowUpController extends Controller
{

    public function index(Request $request)
    {
        $query = FollowUpClient::query();

        if (!empty($request->client))
            $query->where('client_id', $request->client);

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

        $data['lists'] = $query->orderBy('created', 'DESC')->with(['Client', 'TransAgent', 'Court', 'Company'])->paginate($this->perPage);

        $request->request->remove('page');
        $request->request->remove('perPage');
        $data['filter']  = $request->all();

        $data['clients'] = Client::select('share_holder','id')->get();

        return view('client.follow_up_list', $data);
    }


    public function store(Request $request)
    {
        $store = FollowUpClient::find($request->id);
        $store->status = $request->status;
        if ($store->save()) {
            $client_id = $store->client_id;

            $clientsToC = ClientToCompany::where('client_id', $client_id)->get();

            $company_ids = [];
            $flag = true;
            foreach ($clientsToC as $id) {
                $company_ids[] = $id->id;

                $ext_follow_up = FollowUpClient::where('company_id', $id->id)->count();
                if (!$ext_follow_up)
                    $flag = false;
            }
            $followUp = FollowUpClient::whereIn('company_id', $company_ids)->where('status', 'completed')->count();

            $client = Client::find($client_id);
            $client->follow_up_status = 0;
            if ($followUp <= 0 && $flag)
                $client->follow_up_status = 1;

            $client->save();

            return response(['status' => 'success', 'msg' => 'Status Updated Successfully']);
        }
        return response(['status' => 'error', 'Court not Created']);
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


    public function update(CourtRequest $request, $id)
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
