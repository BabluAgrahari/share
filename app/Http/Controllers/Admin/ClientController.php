<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\ClientImages;
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
use Maatwebsite\Excel\Facades\Excel;

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

        if (Auth::user()->role == 'staff' || Auth::user()->role == 'supervisor') {
            $client_ids = !empty(Auth::user()->client_id) ? json_decode(Auth::user()->client_id) : array();
            $query->whereIn('id', $client_ids);
        }

        $data['lists'] = $query->orderBy('created', 'DESC')->with(['Company'])->paginate($this->perPage);

        $request->request->remove('page');
        $request->request->remove('perPage');
        $data['filter']  = $request->all();

        $data['couts'] = Court::where('status', 1)->get();
        $data['clients'] = Client::where('status', 1)->get();
        $data['users']   = User::select('name', 'id')->whereIn('role', ['staff', 'supervisor'])->where('status', 1)->get();

        return view('client.index', $data);
    }

    public function create(Request $request)
    {
        $data['companies'] = Company::select('id', 'company_name')->where('status', 1)->get();
        $data['agents']    = TransferAgent::select('id', 'transfer_agent')->where('status', 1)->get();
        $data['courts'] = Court::select('id', 'court_name')->where('status', 1)->get();
        $data['contacts']  = ContactPerson::select('id', 'name')->where('status', 1)->get();
        return view('client.create', $data);
    }

    public function store(Request $request)
    {
        $store = new Client;
        $store->user_id         = Auth::user()->id;
        $store->file_no         = $request->file_no;
        $store->folio_no        = $request->folio_no;
        $store->court_id        = $request->court_id;
        // $store->srn             = $request->srn;
        $store->date            = strtotime($request->date);
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
        $store->cp_designation  = $request->cp_designation;

        if ($store->save()) {

            if (!empty($request->file('images'))) {
                $images = multipleFile($request->file('images'), 'client_image');
                foreach ($images as $img) {
                    $client_img = new ClientImages();
                    $client_img->user_id   = Auth::user()->id;
                    $client_img->client_id = $store->id;
                    $client_img->image     = $img;
                    $client_img->save();
                }
            }

            self::clientToCompany($request->company, $store->id, 'store'); //insert record into client_to_company table

            $this->storeContactPerson(request: $request, ref_id: $store->id, ref_by: 'client'); //for insert record into contact_person table

            return redirect()->back()->with('success', 'Client Created Successfully');
        }
        return redirect()->back()->with('error', 'Client not Created');
    }


    public function show($id)
    {
        $images = ClientImages::where('client_id', $id)->get();
        $img = '<div class="row">';
        foreach ($images as $image) {

            $img .= '<div class="col-md-3"><div class="card p-2">
           <img src="' . asset('client_image/' . $image->image) . '" style="width: 135px;
    height: 135px;"></div></div>';
        }
        $img .= '</div>';

        return response(['img'=>$img]);
    }


    public function edit($id)
    {
        $data['companies'] = Company::select('id', 'company_name')->where('status', 1)->get();
        $data['agents']    = TransferAgent::select('id', 'transfer_agent')->where('status', 1)->get();
        $data['courts'] = Court::select('id', 'court_name')->where('status', 1)->get();
        $data['client_to_company'] = ClientToCompany::where('client_id', $id)->get();

        $data['res'] = Client::find($id);

        return view('client.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $update =  Client::find($id);
        $update->file_no         = $request->file_no;
        $update->folio_no        = $request->folio_no;
        $update->court_id        = $request->court_id;
        // $update->srn             = $request->srn;
        $update->date            = $request->date;
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
        $update->cp_designation  = $request->cp_designation;

        if (!empty($request->file('image')))
            $update->image  = singleFile($request->file('image'), 'client_image');

        if ($update->save()) {

            if (!empty($request->file('images'))) {
                ClientImages::where('client_id', $update->id)->delete();
                $images = multipleFile($request->file('images'), 'client_image');
                foreach ($images as $img) {
                    $client_img = new ClientImages();
                    $client_img->user_id   = Auth::user()->id;
                    $client_img->client_id = $update->id;
                    $client_img->image     = $img;
                    $client_img->save();
                }
            }

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
            $save->type = $request->type;
            $save->srn  = !empty($request->srn) ? $request->srn : '';
            $save->agent_id = $request->agent_id;
            $save->save();
        }
    }

    public function findClient(Request $request, $id = false)
    {
        if (!$id)
            return false;

        $results = TransferAgent::select('id', 'transfer_agent')->whereRaw("FIND_IN_SET($id, company_id)")->get();

        $option = '<option value="">Select</option>';
        foreach ($results as $res) {
            $selected = !empty($request->agent_id) && $request->agent_id == $res->id ? 'selected' : '';
            $option .= '<option value="' . $res->id . '" ' . $selected . '>' . ucwords($res->transfer_agent) . '</option>';
        }

        die(json_encode($option));
    }

    public function assignUserModal(Request $request)
    {
        $users = User::whereIn('role', ['staff', 'supervisor'])->where('status', 1)->get();

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

            $client_ids = [];
            if (!empty($save->client_id))
                $client_ids = json_decode($save->client_id);
            $client_ids[] = $request->client_id;

            $save->client_id = json_encode($client_ids);
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


    public function export(Request $request)
    {
        return Excel::download(new ClientExport($request), 'client.xlsx');
    }
}
