@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit Court</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('court')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('court/'.$res->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Court Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('court_name')??$res->court_name }}" placeholder="Enter Court Name" name="court_name">
                        @error('court_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>City.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('city')??$res->city }}" placeholder="Enter City" name="city">
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

                </div>
                <div class="row">

                    <div class="form-group col-md-4">
                        <label>Pin</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('pin')??$res->pin }}" placeholder=" Enter Pin" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Address.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('address')??$res->address }}" placeholder=" Enter Address" name="address">
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Contact Person Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_name')??$res->cp_name }}" placeholder="Enter Contact Person Name" name="cp_name">
                        @error('cp_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Email.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_email')??$res->cp_email }}" placeholder="Enter cp_email" name="cp_email">
                        @error('cp_email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Phone.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_phone')??$res->cp_phone }}" placeholder=" Enter Phone" name="cp_phone">
                        @error('cp_phone')
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