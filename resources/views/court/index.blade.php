@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Court</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('court/create')}} " class="btn btn-success btn-sm" style="float:right;"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="p-2 table-responsive">
    <table class="w-100 table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Court Name</th>
                <th>City</th>
                <th>State</th>
                <th>Address</th>
                <th>Pin No</th>
                <th>Contact Person Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{$list->court_name}}</td>
                <td>{{$list->city}}</td>
                <td>{{$list->state}}</td>
                <td>{{$list->address}}</td>
                <td>{{$list->pin}}</td>
                <td>{{$list->cp_name}}</td>
                <td>{{$list->cp_email}}</td>
                <td>{{$list->cp_phone}}</td>
                <td>{{$list->dformat($list->created)}}</td>
               
                <td>
                    <a href="court/{{$list->id}}/edit" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                    <a onclick="return confirm('Are you sure to detele this?')" href="delete5/{{$list->id}}" class="btn btn-sm btn-outline-danger"><span class="mdi mdi-delete"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
       
    </table>
</div>
@endsection