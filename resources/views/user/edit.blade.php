@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('user')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('user/'.$res->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('name')??$res->name }}" placeholder="Enter Name" name="name">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('email')??$res->email}}" placeholder=" Enter Email" name="email">
                        @error('email')
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

                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label>Role</label>
                        <select class="form-control form-control-sm" placeholder="Select Role" name="role">
                            <option value="">Select</option>
                            <option value="admin" {{(old('role')=='admin')?"selected":('admin'==$res->role?'selected':'')}}>Admin</option>
                            <option value="supervisor" {{(old('role')=='supervisor')?"selected":('supervisor'==$res->role?'selected':'')}}>Supervisor</option>
                            <option value="staff" {{(old('role')=='staff')?"selected":('staff'==$res->role?'selected':'')}}>Staff</option>
                        </select>
                        @error('role')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>


                <div class="row">
                    <div class="form-group col-md-4">
                        <label>City</label>
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
                    <div class="form-group col-md-6">
                        <label>Address</label>
                        <textarea class="form-control form-control-sm" placeholder="Enter Address" rows="3" name="address">{{ old('address')??$res->address }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select class="form-control form-control-sm" placeholder="Enter status" name="status">
                            <option value="1" {{(old('status')==1)?"selected":(1==$res->role?'selected':'')}}>Active</option>
                            <option value="0" {{(old('status')==0)?"selected":(0==$res->role?'selected':'')}}>Inactive</option>
                        </select>
                        @error('status')
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