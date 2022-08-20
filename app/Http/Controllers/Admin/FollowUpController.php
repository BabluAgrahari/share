<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FollowUpExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourtRequest;
use App\Http\Requests\FollowUpRequest;
use App\Models\Client;
use App\Models\ClientToCompany;
use App\Models\Company;
use App\Models\ContactPerson;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\FollowUpClient;
use App\Models\FollowUpWith;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        $data['users']   = User::select('name', 'id')->whereIn('role', ['staff', 'supervisor'])->where('status', 1)->get();

        // $data['couts'] = Court::where('status', 1)->get();
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

        $option = '<option value="">Select Company</option>';
        foreach ($copmanies as $list) {
            $option .= '<option value="' . $list->id . '">' . ucwords($list->company_name) . '</option>';
        }

        $agents = ClientToCompany::select('transfer_agents.id', 'transfer_agents.transfer_agent')->join('transfer_agents', 'client_to_company.agent_id', '=', 'transfer_agents.id')
            ->where('client_to_company.client_id', $client_id)->get();

        $optionAgent = '<option value="">Select Agent</option>';
        foreach ($agents as $list) {
            $optionAgent .= '<option value="' . $list->id . '">' . ucwords($list->transfer_agent) . '</option>';
        }
        $followUpList = self::clientFollowUp($client_id);

        $client = Client::find($client_id);
        if (!empty($client)) {
            $court_id = $client->court_id;
            $courts = Court::select('id', 'court_name')->where('id', $court_id)->where('status', 1)->get();
        }

        $optionCourts = '<option value="">Select Court</option>';
        foreach ($courts as $list) {
            $optionCourts .= '<option value="' . $list->id . '">' . ucwords($list->court_name) . '</option>';
        }

        return response(['status' => 'error', 'company' => $option, 'agent' => $optionAgent, 'court' => $optionCourts, 'follow_up_list' => $followUpList]);
    }


    private function clientFollowUp($client_id = false)
    {
        if (!$client_id)
            return false;

        $records = FollowUpClient::with(['user', 'followUpWith.contactPerson', 'followUpWith.user'])->where('client_id', $client_id)->get();

        $list = [];
        foreach ($records as $record) {
            if (!empty($record->followUpWith)) {
                foreach ($record->followUpWith as $follow_up) {

                    $follow_up_with = !empty($follow_up->type) ? $follow_up->type : '';

                    $list[$follow_up_with][] = [
                        'id'             => $record->id,
                        'type'           => $follow_up_with,
                        'remarks'        => $record->remarks,
                        'status'         => $record->status == 'pending' ? 'Follow Up' : ucwords(str_replace('_', ' ', $record->status)),
                        'user_name'      => !empty($record->user->name) ? ucwords($record->user->name) : '',
                        'follow_up_date' => $record->dFormat($record->follow_up_date),
                        'cp_name'        => !empty($follow_up->contactPerson->name) ?
                            ucwords($follow_up->contactPerson->name) : (!empty($follow_up->user->name) ? ucwords($follow_up->user->name) : ''),
                    ];
                }
            }
        }
        return $list;
    }


    public function followUp(FollowUpRequest $request)
    {
        $save = new FollowUpClient();
        $save->user_id        = Auth::user()->id;
        $save->client_id      = $request->client_id;
        $save->follow_up_date = strtotime($request->follow_up_date);

        $save->remarks = $request->remarks;

        if ($save->save()) {

            /*start functionality for followup_with_to_followup table*/
            if ($request->follow_up_for == 'follow_up_user') {

                $followUpWith = new FollowUpWith();
                $followUpWith->user_id      = Auth::user()->id;
                $followUpWith->client_id    = $request->client_id;
                $followUpWith->type         = 'user';
                $followUpWith->follow_up_id = $save->id;
                $followUpWith->with_user_id = $request->with_user_id;
                $followUpWith->save();
            } else if ($request->follow_up_for == 'follow_up_with') {

                foreach ($request->type as $type) {
                    $followUpWith = new FollowUpWith();
                    $followUpWith->user_id      = Auth::user()->id;
                    $followUpWith->client_id    = $request->client_id;
                    $followUpWith->type         = $type;
                    $followUpWith->follow_up_id = $save->id;

                    if ($type == 'company') {
                        $followUpWith->company_id = $request->company_id;
                        $followUpWith->cp_id      = $request->company_cp_id;
                    } else if ($type == 'agent') {
                        $followUpWith->agent_id = $request->agent_id;
                        $followUpWith->cp_id    = $request->agent_cp_id;
                    } else if ($type == 'court') {
                        $followUpWith->court_id = $request->court_id;
                        $followUpWith->cp_id    = $request->court_cp_id;
                    }

                    $followUpWith->save();
                }
            }
            /*start functionality for followup_with_to_followup table*/

            return response(['status' => 'success', 'msg' => 'Follow Up Created Successfully!']);
        }

        return response(['status' => 'error', 'msg' => 'Something went wrong!']);
    }


    public function findContactPerson(Request $request)
    {
        $ref_id = $request->ref_id;
        $ref_by = $request->ref_by;

        $record = ContactPerson::where('ref_id', $ref_id)->where('ref_by', $ref_by)->get();

        $res = '<div class="border p-2 mb-2"><div class="text-primary">' . ucwords($ref_by) . '</div><table class="table mb-3"><tr>
        <th>Select</th>
        <th>Designation</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>
        <a id="add-btn-' . $ref_by . '" ref_id="' . $ref_id . '" ref_by="' . $ref_by . '" href="javascript:void(0);" class="btn btn-outline-primary btn-sm add-new">
        <span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </th>
        </tr>';
        if (!$record->isEmpty()) {
            foreach ($record as $key => $list) {
                $res .= '<tr><td><div class="form-check" style="margin:0px !important; padding:0px !important">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="' . $ref_by . '_cp_id" id="optionsRadios' . $key . '" value="' . $list->id . '"> <i class="input-helper"></i></label>
                            </div>
                </td><td>' . ucwords($list->designation) . '</td><td>' . ucwords($list->name) . '</td><td>' . $list->email . '</td><td>' . $list->mobile . '</td><td></td></tr>';
            }
        } else {
            $res .= '<tr><td colspan="6" class="text-center">Not found any Record</td></tr>';
        }
        $res .= '</table>';

        $res .= '</div>';

        return response(['status' => 'success', 'record' => $res, 'type' => $ref_by]);
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

    public function export(Request $request, $status)
    {
        return Excel::download(new FollowUpExport($request, $status), 'follow_up.xlsx');
    }
}
