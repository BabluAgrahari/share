<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layer;
use App\Models\Company;
use App\Models\client;

class LayerController extends Controller
{
  
    public function index()
    {
        $data['lists'] =Layer::all();
        return view('layer.index',$data);
    }

   
    public function create()
    {
        $data['companies'] = Company::select('id', 'company_name')->get();
        $data['clients']    = Client::select('id', 'share_holder')->get();
        return view('layer.create',$data);
    }

   
    public function store(Request $request)
    {
        $store = new Layer;
        $store->client_id       = $request->client_id;
        $store->company_id     = $request->company_id;
        $store->court_name         = $request->court_name;
        $store->court_address         = $request->court_address;
        $store->layer_name            = $request->layer_name;
        $store->email           = $request->email;
        $store->phone             = $request->phone;

       
        if ($store->save()) {
            return redirect()->back()->with('success', 'Layer Created Successfully');
        }
        return redirect()->back()->with('error', 'Layer not Created');
    }

        
    

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $data['companies'] = Company::select('id', 'company_name')->get();
        $data['clients']    = Client::select('id', 'share_holder')->get();
        $data['res'] =Layer::find($id);
        return view('layer.edit',$data);
    }

   
    public function update(Request $request, $id)
    {
        $update = Layer::find($id);
        $update->client_id       = $request->client_id;
        $update->company_id     = $request->company_id;
        $update->court_name         = $request->court_name;
        $update->court_address         = $request->court_address;
        $update->layer_name            = $request->layer_name;
        $update->email           = $request->email;
        $update->phone             = $request->phone;

        
        if ($update->save()) {
            return redirect()->back()->with('success', 'Layer Created Successfully');
        }
        return redirect()->back()->with('error', 'Layer not Created');
    }

   
    public function delete($id)
    {
        $det = Layer::find($id)->delete();
        if($det)
        {
            return redirect('layer');
        }
    }
}
