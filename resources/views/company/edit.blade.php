@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit Company</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('company')}} " class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>
<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('company/'.$res->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="form-group col-md-4">
                        <label>company_name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('company_name')??$res->company_name }}" placeholder="Enter company_name" name="company_name">
                        @error('company_name')
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

                    <div class="form-group col-md-6">
                        <label>Remarks</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Remarks" name="remarks">{{ old('remarks')??$res->remarks }}</textarea>
                        @error('remarks')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Contant Person</label>
                        <select class="form-control form-control-sm" placeholder="Select Contant" name="cp_id">
                            <option value="">Select</option>
                            @foreach($contacts as $show)
                            <option value="{{ $show->id }}" {{($show->id==$res->contact_person)?"selected":''}}>{{ ucwords($show->name)}}</option>

                            @endforeach
                        </select>
                        @error('cp_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row" id="field_wrapper">
                    <!-- <h6><i class="mdi mdi-account-circle menu-icon"></i>Contact Person Details</h6>
                    <hr> -->
                    <div class="form-group col-md-3">
                        <label>Designation </label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_designation')??$res->cp_designation }}" placeholder=" Enter Designation	" name="cp_designation">
                        @error('cp_designation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Contant Person Name</label>
                        <input type="text" class="form-control form-control-sm" name="cp_name" value="{{ old('cp_name')??$res->cp_name }}" placeholder="Contact Person Name">
                        @error('cp_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label> Email</label>
                        <input type="email" class="form-control form-control-sm" value="{{ old('cp_email')??$res->cp_email }}" name="cp_email" placeholder="Enter Email">
                        @error('cp_email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label> Mobile</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_phone')??$res->cp_phone }}" name="cp_phone" placeholder="Enter Mobile">
                        @error('cp_phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-1">
                        <a href="javascript:void(0)" id="add_more" class="btn btn-xs btn-success mt-4"><span class="mdi mdi-plus"></span></a>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
    var i = 1;
    $('#add_more').click(function() {

        var vendor_id = $(this).attr('vendor_id');
        var fieldHTML = `<div class="row" id="row-${i}">
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control form-control-sm" value="" placeholder=" Enter Designation" name="cp_designation">
                    </div>

                    <div class="form-group col-md-3">
                        <input type="text" class="form-control form-control-sm" name="cp_name" value="" placeholder="Contact Person Name">
                    </div>

                    <div class="form-group col-md-3">
                        <input type="email" class="form-control form-control-sm" value="" name="cp_email" placeholder="Enter Email">
                    </div>

                    <div class="form-group col-md-2">
                        <input type="text" class="form-control form-control-sm" value="" name="cp_phone" placeholder="Enter Mobile">
                    </div>
                    <div class="form-group col-md-1">
                         <a href="javascript:void(0)" onClick="removeRow(${i});" class="btn btn-xs btn-danger"><span class="mdi mdi-delete-forever"></span></a>
                    </div>
                </div>`;

        $('#field_wrapper').append(fieldHTML);
        i++;
    });

    function removeRow(id) {
        var element = document.getElementById("row-" + id);
        element.parentNode.removeChild(element);
    }
</script>
@endpush
@endsection