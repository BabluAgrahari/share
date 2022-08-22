@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Transfer Agent List</h6>
        </div>

        <div class="col-md-6 text-right">
            @if(!empty($filter))
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" id="filter-btn"><span class="mdi mdi-filter-outline-remove"></span>&nbsp;Close</a>
            @else
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="filter-btn"><span class="mdi mdi-filter-outline"></span>&nbsp;Filter</a>
            @endif

            <a href="{{url('transfer-agent-export')}}{{ !empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:''}}" class="btn btn-outline-primary btn-sm"><span class="mdi mdi-cloud-download"></span>&nbsp;Export</a>

            <a href="{{url('transfer-agent/create')}} " class="btn btn-success btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="row mt-2 pl-2 pr-2" id="filter" <?= (empty($filter)) ? "style='display:none'" : "" ?>>
    <div class="col-md-12 ml-auto">
        <form action="{{ url('transfer-agent') }}">
            <div class="form-row">

                <!-- <div class="form-group col-md-2">
                    <label>Date Range</label>
                    <input type="text" class="form-control form-control-sm daterange" value="<?= !empty($filter['date_range']) ? $filter['date_range'] : dateRange() ?>" name="date_range" />
                </div> -->

                <div class="form-group col-md-2">
                    <label>Transfer Agent:</label>
                    <input type="text" class="form-control form-control-sm" name="transfer_agent" value="{{ !empty($filter['transfer_agent']) ? $filter['transfer_agent'] : ''}}" placeholder="Enter Transfer Name">
                </div>

                <div class="form-group col-md-2">
                    <label>Email:</label>
                    <input type="text" class="form-control form-control-sm" name="email" value="{{ !empty($filter['email']) ? $filter['email'] : ''}}" placeholder="Enter Email">
                </div>

                <div class="form-group col-md-2">
                    <label>Phone No:</label>
                    <input type="text" class="form-control form-control-sm" name="phone" value="{{ !empty($filter['phone']) ? $filter['phone'] : ''}}" placeholder="Enter Phone No">
                </div>


                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select class="form-control form-control-sm" name="status">
                        <option value="">All</option>
                        <option value="1" <?= (!empty($filter['status']) && $filter['status'] == '1') ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($filter['status']) && $filter['status'] == '0') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i>&nbsp;Search</button>
                    <a href="{{ url('transfer-agent') }}" class="btn btn-warning btn-sm"><i class="mdi mdi-eraser-variant"></i>&nbsp;Clear</a>
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
                <th>Company Name</th>
                <th>Transfer Agent</th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>Address</th>
                <th colspan="2" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)

            <tr>
                <td>{{ ++$key }}</td>
                <td>{{!empty($list->company->company_name)?ucwords($list->company->company_name):''}}</td>
                <td>{{ucwords($list->transfer_agent)}}</td>
                <td>{{$list->phone}}</td>
                <td>{{$list->email}}</td>
                <td>{{$list->address}}</td>
                <td>
                    <?= $list->status == 1 ? '<a href="javascript:void(0)">
                <span class="activeVer badge badge-outline-success" _id="' . $list->id . '" val="0">Active</span>
                </a>'
                        : '<a href="javascript:void(0);">
                <span class="activeVer badge badge-outline-warning" _id="' . $list->id . '" val="1">Inactive</span>
                </a>' ?>
                </td>
                <td>
                    <a href="transfer-agent/{{$list->id}}/edit" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lists->appends($_GET)->links()}}
</div>
@push('script')
<script>
    $(document).on('click', '.activeVer', function() {
        var id = $(this).attr('_id');
        var val = $(this).attr('val');
        var selector = $(this);
        $.ajax({
            'url': "{{ url('transfer-agent-status') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id,
                'status': val
            },
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if (res.val == 1) {
                    $(selector).text('Active').attr('val', '0').removeClass('badge-outline-warning').addClass('badge-outline-success');
                } else {
                    $(selector).text('Inactive').attr('val', '1').removeClass('badge-outline-success').addClass('badge-outline-warning');
                }
                Swal.fire(
                    `${res.status}!`,
                    res.msg,
                    `${res.status}`,
                )
            }
        })

    })
</script>
@endpush
@endsection