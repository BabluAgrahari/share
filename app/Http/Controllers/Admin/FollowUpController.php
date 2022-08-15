<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourtRequest;
use App\Models\Client;
use App\Models\ClientToCompany;
use App\Models\Company;
use App\Models\ContactPerson;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\FollowUpClient;
use Illuminate\Support\Facades\Auth;

class FollowUpController extends Controller
{

    public function index(Request $request, $status)
    {
        $query = FollowUpClient::query();

        if (!empty($request->client))
            $query->where('client_id', $request->client);

        if (!empty($status) && $status != 'all')
            $query->where('status', $status);

        if (!empty($request->date_range)) {
            list($start_date, $end_date) = explode('-', $request->date_range);
            $start_date = strtotime(trim($start_date) . " 00:00:00");
            $end_date   = strtotime(trim($end_date) . " 23:59:59");
        } else {
            $start_date = $this->start_date;
            $end_date   = $this->end_date;
        }

        $query->whereBetween('created', [$start_date, $end_date]);

        if (Auth::user()->role == 'staff' || Auth::user()->role == 'supervisor') {
            $client_ids = !empty(Auth::user()->client_id) ? json_decode(Auth::user()->client_id) : array();
            $query->whereIn('client_id', $client_ids);
        }

        $data['lists'] = $query->orderBy('created', 'DESC')->with(['Client', 'TransAgent', 'Court', 'Company', 'User'])->paginate($this->perPage);

        $request->request->remove('page');
        $request->request->remove('perPage');
        $data['filter']  = $request->all();

        $data['clients'] = Client::select('share_holder', 'id')->where('status', 1)->get();
        $data['couts'] = Court::where('status', 1)->get();
        $data['status'] = $status;

        return view('follow_up.follow_up_list', $data);
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



    public function findCompany(Request $request)
    {
        $client_id = $request->client_id;

        $copmanies = ClientToCompany::select('companies.id', 'companies.company_name')->join('companies', 'client_to_company.company_id', '=', 'companies.id')
            ->where('client_to_company.client_id', $client_id)->get();

        $option = '<option value="">Select</option>';
        foreach ($copmanies as $list) {
            $option .= '<option value="' . $list->id . '">' . ucwords($list->company_name) . '</option>';
        }

        $agents = ClientToCompany::select('transfer_agents.id', 'transfer_agents.transfer_agent')->join('transfer_agents', 'client_to_company.agent_id', '=', 'transfer_agents.id')
            ->where('client_to_company.client_id', $client_id)->get();

        $optionAgent = '<option value="">Select</option>';
        foreach ($agents as $list) {
            $optionAgent .= '<option value="' . $list->id . '">' . ucwords($list->transfer_agent) . '</option>';
        }
        $followUpList = self::clientFollowUp($client_id);

        return response(['status' => 'error', 'company' => $option, 'agent' => $optionAgent, 'follow_up_list' => $followUpList]);
    }

    private function clientFollowUp($client_id = false)
    {
        if (!$client_id)
            return false;

        $records = FollowUpClient::with(['user'])->where('client_id', $client_id)->get();

        $list = [];
        foreach ($records as $record) {
            $list[$record->type][] = [
                'id'             => $record->id,
                'type'           => $record->type,
                'remarks'        => $record->remarks,
                'status'         => $record->status == 'pending' ? 'Follow Up' : $record->status,
                'user_name'      => !empty($record->user->name) ? $record->user->name : '',
                'follow_up_date' => $record->dFormat($record->follow_up_date)
            ];
        }
        return $list;
    }

    public function followUp(Request $request)
    {
        $save = new FollowUpClient();
        $save->user_id        = Auth::user()->id;
        $save->client_id      = $request->client_id;
        $save->follow_up_date = strtotime($request->follow_up_date);
        $save->type           = $request->type;

        if ($request->type == 'company') {
            $save->company_id = $request->company_id;
        } else if ($request->type == 'agent') {
            $save->agent_id = $request->agent_id;
        } else if ($request->type == 'court') {
            $save->court_id = $request->court_id;
        } else if ($request->type == 'client') {
            $save->with_client_id = $request->client_id;
        }
        $save->remarks = $request->remarks;

        if ($save->save())
            return response(['status' => 'success', 'msg' => 'Follow Up Created Successfully!']);

        return response(['status' => 'error', 'msg' => 'Something went wrong!']);
    }


    public function findContactPerson(Request $request)
    {
        $ref_id = $request->ref_id;
        $ref_by = $request->ref_by;

        $record = ContactPerson::where('ref_id', $ref_id)->where('ref_by', $ref_by)->get();

        $res = '<table class="table mb-3"><tr>
        <th>Designation</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th></th>
        </tr>';
        if (!$record->isEmpty()) {
            foreach ($record as $key => $list) {
                $res .= '<tr><td>' . ucwords($list->designation) . '</td><td>' . ucwords($list->name) . '</td><td>' . $list->email . '</td><td>' . $list->mobile . '</td></tr>';
            }
        } else {
            $res .= '<tr><td colspan="4" class="text-center">Not found any Record</td></tr>';
        }
        $res .= '</table>';

        $res .= '<div id="add-new-btn" class="text-right"><a id="add-new" ref_id="' . $ref_id . '" ref_by="' . $ref_by . '" href="javascript:void(0);" class="btn btn-outline-primary btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Add</a></div> <hr>';

        return response(['status' => 'success', 'record' => $res]);
    }


    public function saveCP(Request $request)
    {
        $ref_id = $request->ref_id;
        $ref_by = $request->ref_by;
        $save = new ContactPerson();
        $save->user_id        = Auth::user()->id;
        $save->name        = $request->name;
        $save->email       = $request->email;
        $save->mobile      = $request->mobile;
        $save->designation = $request->designation;
        $save->ref_id      = $ref_id;
        $save->ref_by      = $ref_by;
        if ($save->save())
            return response(['status' => 'success', 'msg' => 'Added Successfully!']);

        return response(['status' => 'error', 'msg' => 'Something went wrong!']);
    }


    public function revertFollowUp($status, $id)
    {
        $store = FollowUpClient::find($id);
        $store->status = 'pending';
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

            return redirect('follow-up-list/' . $status);
        }
        return redirect('follow-up-list/' . $status);
    }
}
