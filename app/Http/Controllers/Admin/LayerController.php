<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layer;
use App\Models\Company;
use App\Models\client;

class LayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['companies'] = Company::select('id', 'company_name')->get();
        $data['clients']    = Client::select('id', 'share_holder')->get();
        return view('layer.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        // echo "<pre>";
        // print_r($request->all());die;
        if ($store->save()) {
            return redirect()->back()->with('success', 'Layer Created Successfully');
        }
        return redirect()->back()->with('error', 'Layer not Created');
    }

        
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
