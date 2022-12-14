@extends('layout.layout')
@section('content')
<style>
    ul.nav-tab {
        margin-bottom: -31px !important;
        margin-top: -15px !important;
    }
</style>
<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Client</h6>
        </div>

        <div class="col-md-6 text-right">
            @if(!empty($filter))
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" id="filter-btn"><span class="mdi mdi-filter-outline-remove"></span>&nbsp;Close</a>
            @else
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="filter-btn"><span class="mdi mdi-filter-outline"></span>&nbsp;Filter</a>
            @endif
            <a href="{{url('client-export')}}{{ !empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:''}}" class="btn btn-outline-primary btn-sm"><span class="mdi mdi-cloud-download"></span>&nbsp;Export</a>
            <a href="{{url('client/create')}} " class="btn btn-success btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="row mt-2 pl-2 pr-2" id="filter" <?= (empty($filter)) ? "style='display:none'" : "" ?>>
    <div class="col-md-12 ml-auto">
        <form action="{{ url('client') }}">
            <div class="form-row">

                <div class="form-group col-md-2">
                    <label>Date Range</label>
                    <input type="text" class="form-control form-control-sm daterange" value="<?= !empty($filter['date_range']) ? $filter['date_range'] : dateRange() ?>" name="date_range" />
                </div>

                <div class="form-group col-md-3">
                    <label>File NO:</label>
                    <input type="text" class="form-control form-control-sm" name="file_no" value="{{ !empty($filter['file_no']) ? $filter['file_no'] : ''}}" placeholder="Enter File NO">
                </div>

                <div class="form-group col-md-2">
                    <label>Share Holder:</label>
                    <input type="text" class="form-control form-control-sm" name="share_holder" value="{{ !empty($filter['share_holder']) ? $filter['share_holder'] : ''}}" placeholder="Enter Share Holder">
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
                    <a href="{{ url('client') }}" class="btn btn-warning btn-sm"><i class="mdi mdi-eraser-variant"></i>&nbsp;Clear</a>
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
                <th>File No</th>
                <th>Share Holder</th>
                <th>Survivor Name</th>
                <th>City</th>
                <!-- <th>Company</th> -->
                <th>Share Unit</th>
                <th>Follow Up Status</th>
                <th>Created</th>
                <th>Status</th>
                @if(Auth::user()->role=='admin') <th>Assign</th> @endif
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $units = 0;@endphp
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{$list->file_no}}</td>
                <td>{{$list->share_holder}}</td>
                <td>{{$list->survivor_name}}</td>
                <td>{{$list->city}}</td>
                <td>@if(!empty($list->Company))
                    @foreach($list->Company as $camp)
                    <!-- <span>{{$camp->company_id}}</span> -->
                    @php $units +=$camp->unit; @endphp
                    @endforeach
                    @endif
                    {{$units}}
                </td>
                <!-- <td></td> -->
                <td>
                    @if($list->follow_up_status ==1)
                    <span class="badge badge-outline-success">Completed</span>
                    @elseif($list->follow_up_status ==0)
                    <span class="badge badge-outline-warning">Pending</span>
                    @endif
                </td>
                <td>{{ $list->dformat($list->created)}}</td>
                <td>
                    <?= $list->status == 1 ? '<a href="javascript:void(0)">
                <span class="activeVer badge badge-outline-success" _id="' . $list->id . '" val="0">Active</span>
                </a>'
                        : '<a href="javascript:void(0);">
                <span class="activeVer badge badge-outline-warning" _id="' . $list->id . '" val="1">Inactive</span>D
                </a>' ?>
                </td>
                @if(Auth::user()->role=='admin')
                <td> <a href="javascript:void(0);" client_id="{{$list->id}}" class="assignModal btn btn-sm btn-outline-primary" data-toggle="tooltip" data-html="true" title="Assign"><span class="mdi mdi-account-switch"></span></a></td>
                @endif
                <td>
                    <a href="javascript:void(0);" class="images btn btn-sm btn-outline-success" _id="{{$list->id}}" data-toggle="tooltip" data-html="true" title="Client Images"><span class="mdi mdi-file-image"></span></a>
                    <a href="javascript:void(0);" client_name="{{ucwords($list->share_holder)}}" client_id="{{$list->id}}" class="followUpModal btn btn-sm btn-outline-warning" data-toggle="tooltip" data-html="true" title="Follow Up"><span class="mdi mdi-note-text"></span></a>
                    <a href="client/{{$list->id}}/edit" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-html="true" title="Edit"><span class="mdi mdi-pencil-box-outline"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lists->appends($_GET)->links()}}
</div>
@push('modal')
@include('client.assigns')
@include('follow_up.followUp')
<script>
    $(document).on('click', '.activeVer', function() {
        var id = $(this).attr('_id');
        var val = $(this).attr('val');
        var selector = $(this);
        $.ajax({
            'url': "{{ url('client-status') }}",
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

    $('.images').click(function() {
        let id = $(this).attr('_id');
        $.ajax({
            url: '{{url("client")}}/' + id,
            method: 'GET',
            dataType: "JSON",
            success: function(res) {
                $('#image-body').html(res.img);
                $('#imageModal').modal('show');
            }
        })

    })
</script>


<div class="modal fade" id="imageModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="image-body">

            </div>
        </div>
    </div>
</div>
@endpush

@endsection