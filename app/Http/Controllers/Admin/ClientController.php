<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $show = Client::all();
        return view('client.index',['show'=>$show]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = new Client;
        $store->file_no                 =$request->file_no;
        $store->share_holder            =$request->share_holder;
        $store->surivor_name           =$request->surivor_name;
        $store->address                 =$request->address;
        $store->city                    =$request->city;
        $store->state                   =$request->state;
        $store->pin                     =$request->pin;
        $store->contact_person_name     =$request->contact_person_name;
        $store->mobile                  =$request->mobile;
        $store->email                   =$request->email;

        if($store->save())
        {
            return redirect('client/create')->with('success','Data Insert Successfully');
        }
        return redirect('client/create')->with('error','Data Not Insert');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Client::find($id);
        return view('client.edit',['data'=>$data]);
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
        $update =  Client::find($id);
        $update->file_no                 =$request->file_no;
        $update->share_holder            =$request->share_holder;
        $update->surivor_name           =$request->surivor_name;
        $update->address                 =$request->address;
        $update->city                    =$request->city;
        $update->state                   =$request->state;
        $update->pin                     =$request->pin;
        $update->contact_person_name     =$request->contact_person_name;
        $update->mobile                  =$request->mobile;
        $update->email                   =$request->email;

        if($update->save())
        {
            return redirect('client')->with('success','Data Insert Successfully');
        }
        return redirect('client')->with('error','Data Not Insert');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $det = Client::find($id)->delete();
        if($det)
        {
            return redirect('client');
        }

    }
}
