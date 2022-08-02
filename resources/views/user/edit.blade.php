@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('list')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- @method('put') -->
                <div class="row">
                    <input type="hidden" name="id" value="{{$res->id}}">
                    <div class="form-group col-md-4">
                        <label>Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('name')??$res->name }}" placeholder="Enter Name" name="name">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Mobile No.</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('mobile')??$res->mobile}}" placeholder="Enter Mobile No." name="mobile">
                        @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Address</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Address" value="{{old('address')??$res->address}}" name="address">
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label>City.</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('city')??$res->city}}" placeholder="Enter City." name="city">
                        @error('city')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>State</label>
                        <select class="form-control form-control-sm" placeholder="Enter State" name="state">
                            <option value=" ">Select</option>
                            @foreach(config('global.state') as $state)
                            <option value="{{$state}}" {{(old('state')==$state)?"selected":($state==$res->state?'selected':'')}}>{{$state}}</option>
                            @endforeach
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Pin</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('pin')??$res->pin}}" placeholder="Enter Pin Code" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('email')??$res->email}}" placeholder=" Enter Email" name="email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Password</label>
                        <input type="password" class="form-control form-control-sm"  placeholder=" Enter Password" name="password">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Confirm Password</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('confirm_password')??$res->confirm_password}}" placeholder=" Enter Confirm Password" name="confirm_password">
                        @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="form-group col-md-4">
                    <label>Role</label>
                    <select class="form-control form-control-sm" placeholder="Select Role"  name="role">
                        <option value=" ">Select</option>
                        <option value="{{$res->id}}">Admin</option>
                        <option value="{{$res->rol}}">Superwiser</option>
                        <option value="{{$res->rol}}">Staff</option>
                        
                    </select>
                    @error('role')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection