@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit Client</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('client')}} " class="btn btn-warning btn-sm" style="float:right;"><span
                    class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>
<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('client/'.$res->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="form-group col-md-4">
                        <label>File No</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ old('file_no')??$res->file_no }}" placeholder="Enter File No" name="file_no">
                        @error('file_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Share Holder</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ old('share_holder')??$res->share_holder }}" placeholder="Enter Share Holder"
                            name="share_holder">
                        @error('share_holder')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Survivor Name</label>
                        <input type="text" class="form-control form-control-sm"
                            value="{{ old('survivor_name')??$res->survivor_name }}" placeholder=" Enter Survivor Name"
                            name="survivor_name">
                        @error('survivor_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('city')??$res->city }}"
                            placeholder="Enter City" name="city">
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>State</label>
                        <select class="form-control form-control-sm" placeholder="Enter State" name="state">
                            <option value="">Select</option>
                            @foreach(config('global.state') as $state)
                            <option value="{{$state}}">{{$state}}</option>
                            @endforeach
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Pin</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('pin')??$res->pin }}"
                            placeholder="Enter Pin Code" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Address"
                            name="address">{{ old('address')??$res->address }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Contant Person</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="contact_person_id">
                            <option value="">Select</option>
                            @foreach($contacts as $show)
                            <option value="{{ $show->id }}" {{($show->id==$res->contact_person)?"selected":''}}>
                                {{ ucwords($show->name)}}</option>

                            @endforeach
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Transfer Agent</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="agent_id">
                            <option value="">Select</option>
                            @foreach($agents as $show)
                            <option value="{{ $show->id }}" {{($show->id==$res->agent_id)?"selected":''}}>
                                {{ ucwords($show->agency_name)}}</option>

                            @endforeach
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Company Name</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="company_id">
                            <option value="">Select</option>
                            @foreach($companies as $show)
                            <option value="{{ $show->id }}" {{($show->id==$res->company_id)?"selected":''}}>
                                {{ ucwords($show->company_name)}}</option>

                            @endforeach
                        </select>
                        @error('company')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection