@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Add Layer</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('layer')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('layer')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Court Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('court_name') }}" placeholder="Enter Court Name" name="court_name">
                        @error('court_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Court Address.</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('court_address') }}" placeholder="Enter Address" name="court_address">
                        @error('court_address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Layer Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('layer_name') }}" placeholder=" Enter Layer Name" name="layer_name">
                        @error('layer_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4">
                        <label>Email</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('email') }}" placeholder=" Enter Email" name="email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Phone</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('phone') }}" placeholder=" Enter Phone" name="phone">
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Client Name</label>
                        <select class="form-control form-control-sm" placeholder="Enter Client Name" name="client_id">
                            <option value=" ">Select</option>
                            @foreach($clients as $show)
                            <option value="{{ $show->id }}">{{ ucwords($show->share_holder)}}</option>

                            @endforeach
                        </select>
                        @error('client_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>Company Name</label>
                    <select class="form-control form-control-sm" placeholder="Enter Company Name" name="company_id">
                        <option value=" ">Select</option>
                        @foreach($companies as $show)
                        <option value="{{ $show->id }}">{{ ucwords($show->company_name)}}</option>

                        @endforeach
                    </select>
                    @error('company_id')
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