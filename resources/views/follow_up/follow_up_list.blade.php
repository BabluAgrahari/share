@extends('layout.layout')
@section('content')

<div class="card-header py-2 pb-0 h-body">
    <!-- <div class="row"> -->
    <!-- <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Follow Up List</h6>
        </div> -->
    <!-- <div class="col-md-6 mb-1"> -->
    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: -29px !important;">
        <li class="nav-item">
            <a class="nav-link {{$status=='all'?'active':''}}" href="{{url('follow-up-list/all')}}">
                <h5 class="modal-title">All Clients</h5>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$status=='pending'?'active':''}}" href="{{url('follow-up-list/pending')}}">
                <h5 class="modal-title">Follow Up</h5>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$status=='on_hold'?'active':''}}" href="{{url('follow-up-list/on_hold')}}">
                <h5 class="modal-title">On Hold</h5>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$status=='completed'?'active':''}}" href="{{url('follow-up-list/completed')}}">
                <h5 class="modal-title">Completed</h5>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{$status=='rejected'?'active':''}}" href="{{url('follow-up-list/rejected')}}">
                <h5 class="modal-title">Rejected</h5>
            </a>
        </li>
    </ul>
    <!-- </div> -->

    <div class="text-right filter">
        @if(!empty($filter))
        <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" id="filter-btn"><span class="mdi mdi-filter-remove-outline"></span>&nbsp;Close</a>
        @else
        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="filter-btn"><span class="mdi mdi-filter-outline"></span>&nbsp;Filter</a>
        @endif
        <a href="{{url('follow-up-export')}}{{ !empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:''}}" class="btn btn-outline-primary btn-sm"><span class="mdi mdi-cloud-download"></span>&nbsp;Export</a>
    </div>
    <!-- </div> -->
</div>

<div class="row mt-2 pl-2 pr-2" id="filter" <?= (empty($filter)) ? "style='display:none'" : "" ?>>
    <div class="col-md-12 ml-auto">
        <form action="{{ url('follow-up-list') }}">
            <div class="form-row">

                <div class="form-group col-md-2">
                    <label>Date Range</label>
                    <input type="text" class="form-control form-control-sm daterange" value="<?= !empty($filter['date_range']) ? $filter['date_range'] : dateRange() ?>" name="date_range" />
                </div>


                <div class="form-group col-md-2">
                    <label>Client</label>
                    <select class="form-control form-control-sm" name="client">
                        <option value="">All</option>
                        @foreach($clients as $client)
                        <option value="{{$client->id}}" <?= (!empty($filter['client']) && $filter['client'] == $client->id) ? 'selected' : '' ?>>{{ucwords($client->share_holder)}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select class="form-control form-control-sm" name="status">
                        <option value="">All</option>
                        <option value="pending" <?= (!empty($filter['status']) && $filter['status'] == 'pending') ? 'selected' : '' ?>>Follow Up</option>
                        <option value="on_hold" <?= (!empty($filter['status']) && $filter['status'] == 'pending') ? 'selected' : '' ?>>On Hold</option>
                        <option value="completed" <?= (isset($filter['status']) && $filter['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                        <option value="rejected" <?= (isset($filter['status']) && $filter['status'] == 'rejected') ? 'selected' : '' ?>>Rejected</option>
                        <option value="revert" <?= (isset($filter['status']) && $filter['status'] == 'revert') ? 'selected' : '' ?>>Revert</option>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i>&nbsp;Search</button>
                    <a href="{{ url('follow-up-list') }}" class="btn btn-warning btn-sm"><i class="mdi mdi-eraser-variant"></i>&nbsp;Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="p-2 table-responsive">
    <table class="w-100 table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>File No.</th>
                <th>Share Holder</th>
                <th>Survivor Name</th>
                <th>City</th>
                <th>Admin Name</th>
                <th>Last User</th>
                <th>Follow Up Date</th>
                <th>Remarks</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{!empty($list->client->file_no)?$list->client->file_no:''}}</td>
                <td>{{!empty($list->client->share_holder) ? $list->client->share_holder : ''}}</td>
                <td>{{!empty($list->client->survivor_name) ? $list->client->survivor_name : ''}}</td>
                <td>{{!empty($list->client->city) ? $list->client->city : ''}}</td>
                <td></td>
                <td>{{!empty($list->user->name) ? ucwords($list->user->name) : ''}}</td>
                <td>{{$list->dformat($list->follow_up_date)}}</td>
                <!-- <td>{{ucwords($list->type)}}</td> -->
                <!-- <td><?php
                            if ($list->type == 'company') {
                                // echo !empty($list->company->company_name) ? $list->company->company_name : '';
                            } else if ($list->type == 'agent') {
                                //  echo !empty($list->trans_agent->transfer_agent) ? $list->trans_agent->transfer_agent : '';
                            } else if ($list->type == 'court') {
                                // echo !empty($list->court->court_name) ? $list->court->court_name : '';
                            }
                            ?></td> -->
                <td>{{$list->remarks}}</td>
                <td>
                    @if($list->status =='rejected')
                    <span class="badge badge-outline-danger">Rejected</span>
                    @elseif($list->status=='completed')
                    <span class="badge badge-outline-success">Completed</span>
                    @elseif($list->status =='on_hold')
                    <span class="badge badge-outline-info">On Hold</span>
                    @else
                    <span class="badge badge-outline-warning">Follow Up</span>
                    @endif
                </td>
                <td>
                    @if($status =='completed' || $status =='rejected')
                    <a onclick="return confirm('Are you sure to Revert this?')" href="{{url('revert-follow-up/'.$status.'/'.$list->id)}}" class="revert btn btn-sm btn-outline-success" data-toggle="tooltip" data-html="true" title="Revert"><span class="mdi mdi-recycle"></span></a>
                    @else
                    <a href="javascript:void(0);" client_name="{{!empty($list->client->share_holder) ? ucwords($list->client->share_holder) : ''}}" client_id="{{!empty($list->client->id) ? $list->client->id : ''}}" class="followUpModal btn btn-sm btn-outline-warning" data-toggle="tooltip" data-html="true" title="Follow Up"><span class="mdi mdi-note-text"></span></a>
                    @endif
                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-info edit" _id="{{$list->id}}" data-toggle="tooltip" data-html="true" title="Update Status"><span class="mdi mdi-pencil-box-outline"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lists->appends($_GET)->links()}}
</div>

@push('modal')
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Status
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="follow-up" action="{{ url('follow-up-list')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="" id="id">
                    <div class="form-group">
                        <label>Select Status</label>
                        <select class="form-control form-control-sm" name="status" id="status">
                            <option value="select">Select</option>
                            <!-- <option value="pending">Follow Up</option> -->
                            @if($status !='on_hold')
                            <option value="on_hold">On Hold</option>
                            @endif
                            <option value="completed">Completed</option>
                            <option value="rejected">Rejected</option>
                            @if($status !='on_hold')
                            <option value="penidng">Revert</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-sm btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.edit').click(function() {
        $('#id').val($(this).attr('_id'));
        $('#myModal').modal('show');
    });

    /*start form submit functionality*/
    $("form#follow-up").submit(function(e) {
        e.preventDefault();
        formData = new FormData(this);
        var url = $(this).attr('action');
        $.ajax({
            data: formData,
            type: "POST",
            url: url,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.cover-loader').removeClass('d-none');
                $('#outlet').hide();
            },
            success: function(res) {
                $('.cover-loader').addClass('d-none');
                $('#outlet').show();

                /*Start Status message*/
                if (res.status == 'success' || res.status == 'error') {
                    Swal.fire(
                        `${res.status}!`,
                        res.msg,
                        `${res.status}`,
                    )
                }
                /*End Status message*/

                //for reset all field
                if (res.status == 'success') {
                    $('form#follow-up')[0].reset();
                    setTimeout(function() {
                        location.reload();
                    }, 1000)
                }
            }
        });
    });
    /*end form submit functionality*/
</script>
@include('follow_up.followUp')
@endpush

@endsection