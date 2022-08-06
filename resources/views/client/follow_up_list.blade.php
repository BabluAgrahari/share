@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Follow Up List</h6>
        </div>

        <div class="col-md-6">

        </div>
    </div>
</div>
<div class="p-2 table-responsive">
    <table class="w-100 table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Client Name</th>
                <th>Follow Up Date</th>
                <th>To</th>
                <th>Name</th>
                <th>Remarks</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{!empty($list->client->share_holder) ? $list->client->share_holder : ''}}</td>
                <td>{{$list->dformat($list->follow_up_date)}}</td>
                <td>{{ucwords($list->type)}}</td>
                <td><?php
                    if ($list->type == 'company') {
                        echo !empty($list->company->company_name) ? $list->company->company_name : '';
                    } else if ($list->type == 'agent') {
                        echo !empty($list->trans_agent->transfer_agent) ? $list->trans_agent->transfer_agent : '';
                    } else if ($list->type == 'court') {
                        echo !empty($list->court->court_name) ? $list->court->court_name : '';
                    }
                    ?></td>
                <td>{{$list->remarks}}</td>
                <td>{{ $list->dformat($list->created)}}</td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-html="true" title="Update Status"><span class="mdi mdi-pencil-box-outline"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lists->appends($_GET)->links()}}
</div>
@endsection