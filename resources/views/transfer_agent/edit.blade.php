@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Add Transfer Agent</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('transfer-agent')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('transfer-agent/'.$res->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Agency Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('agency_name')??$res->agency_name }}" placeholder="Enter agency_name" name="agency_name">
                        @error('agency_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Phone No.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('phone')??$res->phone }}" placeholder="Enter Phone No." name="phone">
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('email')??$res->email }}" placeholder=" Enter Email" name="email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('city')??$res->city }}" placeholder="Enter City" name="city">
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>State</label>
                        <select class="form-control form-control-sm" placeholder="Enter State" name="state">
                            <option value="">Select</option>
                            <option>up</option>
                            <option>delhi</option>
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Pin</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('pin')??$res->pin }}" placeholder="Enter Pin Code" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Address" name="address">{{ old('address')??$res->address }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Contant Person</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="contact_person_id">
                            <option value="">Select</option>
                            @foreach($contacts as $show)
                            <option value="{{ $show->id }}" {{($show->id==$res->contact_person)?"selected":''}}>{{ ucwords($show->name)}}</option>

                            @endforeach
                        </select>
                        @error('state')
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