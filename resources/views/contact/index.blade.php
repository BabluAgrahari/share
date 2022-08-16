@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Contact Person List</h6>
        </div>

        <div class="col-md-6 text-right">
            @if(!empty($filter))
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" id="filter-btn"><span class="mdi mdi-filter-outline-remove"></span>&nbsp;Close</a>
            @else
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="filter-btn"><span class="mdi mdi-filter-outline"></span>&nbsp;Filter</a>
            @endif


            <a href="{{url('c-person-export')}}{{ !empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:''}}" class="btn btn-outline-primary btn-sm"><span class="mdi mdi-cloud-download"></span>&nbsp;Export</a>

            <!-- <a href="{{url('contact/create')}} " class="btn btn-success btn-sm" style="float:right;"><span class="mdi mdi-plus"></span>&nbsp;Add</a> -->
        </div>
    </div>
</div>
<div class="row mt-2 pl-2 pr-2" id="filter" <?= (empty($filter)) ? "style='display:none'" : "" ?>>
    <div class="col-md-12 ml-auto">
        <form action="{{ url('contact-person') }}">
            <div class="form-row">

                <!-- <div class="form-group col-md-2">
                    <label>Date Range</label>
                    <input type="text" class="form-control form-control-sm daterange" value="<?= !empty($filter['date_range']) ? $filter['date_range'] : dateRange() ?>" name="date_range" />
                </div> -->

                <div class="form-group col-md-2">
                    <label>Designation</label>
                    <input type="text" class="form-control form-control-sm" name="designation" value="{{ !empty($filter['designation']) ? $filter['designation'] : ''}}" placeholder="Enter Designation">
                </div>

                <div class="form-group col-md-2">
                    <label>Name</label>
                    <input type="text" class="form-control form-control-sm" name="name" value="{{ !empty($filter['name']) ? $filter['name'] : ''}}" placeholder="Enter Name">
                </div>

                <div class="form-group col-md-2">
                    <label>Email</label>
                    <input type="text" class="form-control form-control-sm" name="email" value="{{ !empty($filter['email']) ? $filter['email'] : ''}}" placeholder="Enter Email">
                </div>

                <div class="form-group col-md-2">
                    <label>Phone</label>
                    <input type="number" class="form-control form-control-sm" name="phone" value="{{ !empty($filter['phone']) ? $filter['phone'] : ''}}" placeholder="Enter Phone No.">
                </div>

                <div class="form-group col-md-2">
                    <label>Type</label>
                    <select class="form-control form-control-sm" name="ref_by">
                        <option value="">All</option>
                        <option value="company" <?= (!empty($filter['ref_by']) && $filter['ref_by'] == 'company') ? 'selected' : '' ?>>Company</option>
                        <option value="agent" <?= (isset($filter['ref_by']) && $filter['ref_by'] == 'agent') ? 'selected' : '' ?>>Agent</option>
                        <option value="court" <?= (isset($filter['ref_by']) && $filter['ref_by'] == 'court') ? 'selected' : '' ?>>Court</option>
                        <option value="client" <?= (isset($filter['ref_by']) && $filter['ref_by'] == 'client') ? 'selected' : '' ?>>Client</option>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i>&nbsp;Search</button>
                    <a href="{{ url('contact-person') }}" class="btn btn-warning btn-sm"><i class="mdi mdi-eraser-variant"></i>&nbsp;Clear</a>
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
                <th>Designation</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Type</th>
                <!-- <th>Status</th> -->
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ucwords($list->designation)}}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->mobile}}</td>
                <td>{{$list->email}}</td>
                <td>{{ucwords($list->ref_by)}}</td>
                <!-- <td>{!!$list->status == 1 ? '<span class="badge badge-success">Avtive</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td> -->
                <!-- <td>
                    <a href="contact/{{$list->id}}/edit" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                </td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $lists->appends($_GET)->links()}}
</div>
@endsection