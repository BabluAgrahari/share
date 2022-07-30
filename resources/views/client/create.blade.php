@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Add Client</h6>
        </div>

         <div class="col-md-6">
                <a href="{{url('client')}} " class="btn btn-success btn-sm" style="float:right;">Back</a>
            </div> 
    </div>
</div>
<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('client')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>File No:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter File No" name="file_no">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Share Holder:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Share Holder" name="share_holder">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Survivor Name:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Survivor Name" name="surivor_name">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Address:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Address" name="address">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>City:</label>
                        <select class="form-control form-control-sm" placeholder="Enter City" name="city">
                        <option>select</option>
                        <option>delhi</option>
                        <option>bandi</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>State:</label>
                        <select class="form-control form-control-sm" placeholder="Enter State" name="state">
                        <option>select</option>
                        <option>up</option>
                        <option>delhi</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Pin Code:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Pin Code" name="pin">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Contact Person Name:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Contact Person Name" name="contact_person_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mobile:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Mobile Number" name="mobile">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Email:</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Email" name="email">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection