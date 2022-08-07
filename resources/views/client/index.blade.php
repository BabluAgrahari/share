@extends('layout.layout')
@section('content')

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
            <a href="{{url('client/create')}} " class="btn btn-success btn-sm" style="float:right;"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="row mt-2 pl-2 pr-2" id="filter" <?= (empty($filter)) ? "style='display:block'" : "" ?>>
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