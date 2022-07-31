@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Add Client</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('client')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('client')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>File No</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('file_no') }}" placeholder="Enter File No" name="file_no">
                        @error('file_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Share Holder</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('share_holder') }}" placeholder="Enter Share Holder" name="share_holder">
                        @error('share_holder')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Survivor Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('surivor_name') }}" placeholder=" Enter Survivor Name" name="surivor_name">
                        @error('surivor_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('city')}}" placeholder="Enter City" name="city">
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>State</label>
                        <select class="form-control form-control-sm" placeholder="Enter State" name="state">
                            <option>Select</option>
                            <option>up</option>
                            <option>delhi</option>
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Pin</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('pin') }}" placeholder="Enter Pin Code" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Address" name="address">{{ old('surivor_name') }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Contant Person</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="contact_person_id">
                            <option>Select</option>
                            @foreach($contacts as $show)
                            <option value="{{ $show->id }}">{{ ucwords($show->name)}}</option>

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
                            <option>Select</option>
                            @foreach($agents as $show)
                            <option value="{{ $show->id }}">{{ ucwords($show->agency_name)}}</option>

                            @endforeach
                        </select>
                        @error('agent')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Compnay Name</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="company_id">
                            <option>Select</option>
                            @foreach($companies as $show)
                            <option value="{{ $show->id }}">{{ ucwords($show->company_name)}}</option>

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