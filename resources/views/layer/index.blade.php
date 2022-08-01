@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Layer</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('layer/create')}} " class="btn btn-success btn-sm" style="float:right;"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="p-2 table-responsive">
    <table class="w-100 table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Court Name</th>
                <th>Court Address</th>
                <th>Layer Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{$list->court_name}}</td>
                <td>{{$list->court_address}}</td>
                <td>{{$list->layer_name}}</td>
                <td>{{$list->email}}</td>
                <td>{{$list->phone}}</td>
               
                <td>
                    <a href="layer/{{$list->id}}/edit" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                    <a onclick="return confirm('Are you sure to detele this?')" href="delete5/{{$list->id}}" class="btn btn-sm btn-outline-danger"><span class="mdi mdi-delete"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
       
    </table>
</div>
@endsection