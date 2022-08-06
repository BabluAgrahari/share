@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Client</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('client/create')}} " class="btn btn-success btn-sm" style="float:right;"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="p-2 table-responsive">
    <table class="w-100 table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>File No</th>
                <th>Share Holder</th>
                <th>Survivor Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Pin</th>
                <th>Created</th>
                <th>Assign</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{$list->file_no}}</td>
                <td>{{$list->share_holder}}</td>
                <td>{{$list->survivor_name}}</td>
                <td>{{$list->address}}</td>
                <td>{{$list->city}}</td>
                <td>{{$list->state}}</td>
                <td>{{$list->pin}}</td>
                <td>{{ $list->dformat($list->created)}}</td>
                <td> <a href="javascript:void(0);" client_id="{{$list->id}}" class="assignModal btn btn-sm btn-outline-success">Assign</a></td>
                <td>
                    <a href="javascript:void(0);" client_id="{{$list->id}}" class="followUpModal btn btn-sm btn-outline-warning">Follow Up</a>
                    <a href="client/{{$list->id}}/edit" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lists->appends($_GET)->links()}}
</div>
@push('modal')
@include('client.remarks')
@include('client.followUp')
@endpush
@endsection