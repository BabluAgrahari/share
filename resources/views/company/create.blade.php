@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Add Company</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('company')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('company')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Company Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('company_name') }}" placeholder="Enter Company Name" name="company_name">
                        @error('company_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Phone No.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('phone') }}" placeholder="Enter Phone No." name="phone">
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('email') }}" placeholder=" Enter Email" name="email">
                        @error('email')
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
                            <option value=" ">Select</option>
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
                        <input type="text" class="form-control form-control-sm" value="{{ old('pin') }}" placeholder="Enter Pin Code" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Address" rows="3" name="address">{{ old('address') }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Remarks</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Remarks" rows="3" name="remarks">{{ old('remarks') }}</textarea>
                        @error('remarks')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="row">
                    <!-- <h6><i class="mdi mdi-account-circle menu-icon"></i>Contact Person Details</h6>
                    <hr> -->
                    <div class="form-group col-md-3">
                        <label>Contant Person Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_name') }}" name="cp_name" placeholder="Contact Person Name">
                        @error('cp_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label> Email</label>
                        <input type="email" class="form-control form-control-sm" value="{{ old('cp_email') }}" name="cp_email" placeholder="Enter Email">
                        @error('cp_email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label> Mobile</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_phone') }}" name="cp_phone" placeholder="Enter Mobile">
                        @error('cp_phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                    <label>Designation </label>
                    <input type="text" class="form-control form-control-sm" value="{{ old('cp_designation') }}" placeholder=" Enter Designation	" name="cp_designation">
                    @error('cp_designation')
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