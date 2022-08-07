<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientToCompany;
use App\Models\ContactPerson;
use App\Models\Company;
use App\Models\Court;
use App\Models\FollowUpClient;
use App\Models\TransferAgent;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function index(Request $request)
    {

        $query = Client::query();

        if (!empty($request->file_no))
            $query->where('file_no', 'LIKE', "%$request->file_no%");

        if (!empty($request->share_holder))
            $query->where('share_holder', $request->share_holder);

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

        $data['couts'] = Court::get();

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
        $store->user_id         = Auth::user()->id;
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

            $this->storeContactPerson(request: $request, ref_id: $store->id, ref_by: 'client'); //for insert record into contact_person table

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

            self::clientToCompany($request->company, $update->id, 'update'); //update record into client_to_company table

            $this->updateContactPerson(request: $request, ref_id: $id, ref_by: 'client'); //for update record into contact_person table

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


    public function status(Request $request)
    {
        try {
            $save = Client::find($request->id);
            $save->status = (int)$request->status;
            $save->save();
            if ($save->status == 1)
                return response(['status' => 'success', 'msg' => 'This Client is Active!', 'val' => $save->status]);

            return response(['status' => 'success', 'msg' => 'This Client is Inactive!', 'val' => $save->status]);
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Something went wrong!!']);
        }
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

    public function assignUserModal(Request $request)
    {
        $users = User::whereIn('role', ['staff', 'supervisor'])->get();

        $staff = '';
        $supervisor = '';
        foreach ($users as $key => $list) {
            $checked = ($list->client_id == $request->client_id) ? 'checked' : '';

            if ($list->role == 'staff') {
                $staff .= '<tr>
                                        <td>' . ucwords($list->name) . '</td>
                                        <td>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                    <input type="checkbox" value="' . $list->id . '" name="user[]" class="form-check-input" ' . $checked . '><i class="input-helper"></i></label>
                                            </div>
                                        </td>
                                    </tr>';
            } else if ($list->role == 'supervisor') {
                $supervisor .= ' <tr>
                                        <td>' . ucwords($list->name) . '</td>
                                        <td>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                    <input type="checkbox" value="' . $list->id . '" name="user[]" class="form-check-input" ' . $checked . '><i class="input-helper"></i></label>
                                            </div>
                                        </td>
                                    </tr>';
            }
        }

        return response(['status' => 'success', 'staff' => $staff, 'supervisor' => $supervisor]);
    }

    public function assignUser(Request $request)
    {
        foreach ($request->user as $id) {
            $save = User::find($id);
            $save->client_id = $request->client_id;
            $res = $save->save();
        }

        if ($res) {
            $client = Client::find($request->client_id);
            $client->user_ids = json_encode($request->user);
            $client->save();
            return response(['status' => 'success', 'msg' => 'Assigned Successfully!']);
        }

        return response(['status' => 'error', 'msg' => 'Something went wrong!']);
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

        $agents = ClientToCompany::select('transfer_agents.id', 'transfer_agents.agency_name')->join('transfer_agents', 'client_to_company.agent_id', '=', 'transfer_agents.id')
            ->where('client_to_company.client_id', $client_id)->get();

        $optionAgent = '<option value="">Select</option>';
        foreach ($agents as $list) {
            $optionAgent .= '<option value="' . $list->id . '">' . ucwords($list->agency_name) . '</option>';
        }

        return response(['status' => 'error', 'company' => $option, 'agent' => $optionAgent]);
    }

    public function followUp(Request $request)
    {
        $save = new FollowUpClient();
        $save->client_id = $request->client_id;
        $save->follow_up_date = strtotime($request->follow_up_date);
        $save->type = $request->type;

        if ($request->type == 'company') {
            $save->company_id = $request->company_id;
        } else if ($request->type == 'agent') {
            $save->agent_id = $request->agent_id;
        } else if ($request->type == 'court') {
            $save->court_id = $request->court_id;
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
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        </tr>';
        if (!$record->isEmpty()) {
            foreach ($record as $key => $list) {
                $res .= '<tr><td>' . ucwords($list->name) . '</td><td>' . $list->email . '</td><td>' . $list->mobile . '</td></tr>';
            }
        } else {
            $res .= '<tr><td colspan="3" class="text-center">Not found any Record</td></tr>';
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
        $save->name   = $request->name;
        $save->email  = $request->email;
        $save->mobile = $request->mobile;
        $save->ref_id = $ref_id;
        $save->ref_by = $ref_by;
        if ($save->save())
            return response(['status' => 'success', 'msg' => 'Created Successfully!']);

        return response(['status' => 'error', 'msg' => 'Something went wrong!']);
    }
}
