@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Follow Up List</h6>
        </div>

        <div class="col-md-6 text-right">
            @if(!empty($filter))
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" id="filter-btn"><span class="mdi mdi-filter-remove-outline"></span>&nbsp;Close</a>
            @else
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="filter-btn"><span class="mdi mdi-filter-outline"></span>&nbsp;Filter</a>
            @endif
        </div>
    </div>
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
                        <option value="pending" <?= (!empty($filter['status']) && $filter['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="completed" <?= (isset($filter['status']) && $filter['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                        <option value="rejected" <?= (isset($filter['status']) && $filter['status'] == 'rejected') ? 'selected' : '' ?>>Rejected</option>
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
                <th>Client Name</th>
                <th>Follow Up Date</th>
                <th>To</th>
                <th>Name</th>
                <th>Remarks</th>
                <th>Created</th>
                <th>Status</th>
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
                    @if($list->status =='rejected')
                    <span class="badge badge-outline-danger">Rejected</span>
                    @elseif($list->status=='completed')
                    <span class="badge badge-outline-success">Completed</span>
                    @else
                    <span class="badge badge-outline-warning">Pending</span>
                    @endif
                </td>
                <td>
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
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="rejected">Rejected</option>
                            <option value="pending">Revert</option>
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
@endpush

@endsection