@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">User</h6>
        </div>

        <div class="col-md-6 text-right">
            @if(!empty($filter))
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" id="filter-btn"><span class="mdi mdi-filter-outline-remove"></span>&nbsp;Close</a>
            @else
            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" id="filter-btn"><span class="mdi mdi-filter-outline"></span>&nbsp;Filter</a>
            @endif
            <a href="{{url('user/create')}} " class="btn btn-success btn-sm"><span class="mdi mdi-plus"></span>&nbsp;Add</a>
        </div>
    </div>
</div>
<div class="row mt-2 pl-2 pr-2" id="filter" <?= (empty($filter)) ? "style='display:block'" : "" ?>>
    <div class="col-md-12 ml-auto">
        <form action="{{ url('user') }}">
            <div class="form-row">

                <div class="form-group col-md-2">
                    <label>Date Range</label>
                    <input type="text" class="form-control form-control-xs daterange" value="<?= !empty($filter['date_range']) ? $filter['date_range'] : dateRange() ?>" name="date_range" />
                </div>

                <div class="form-group col-md-2">
                    <label>Name:</label>
                    <input type="text" class="form-control form-control-xs" name="name" value="{{ !empty($filter['name']) ? $filter['name'] : ''}}" placeholder="Enter Name">
                </div>

                <div class="form-group col-md-2">
                    <label>Email:</label>
                    <input type="text" class="form-control form-control-xs" name="email" value="{{ !empty($filter['email']) ? $filter['email'] : ''}}" placeholder="Enter Email">
                </div>

                <div class="form-group col-md-2">
                    <label>Phone No:</label>
                    <input type="text" class="form-control form-control-xs" name="mobile" value="{{ !empty($filter['mobile']) ? $filter['mobile'] : ''}}" placeholder="Enter Phone No">
                </div>


                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select class="form-control form-control-xs" name="status">
                        <option value="">All</option>
                        <option value="1" <?= (!empty($filter['status']) && $filter['status'] == '1') ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($filter['status']) && $filter['status'] == '0') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i>&nbsp;Search</button>
                    <a href="{{ url('user') }}" class="btn btn-warning btn-sm"><i class="mdi mdi-eraser-variant"></i>&nbsp;Clear</a>
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
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>City</th>
                <th>Role</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lists as $key => $list)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ucwords($list->name)}}</td>
                <td>{{$list->email}}</td>
                <td>{{$list->mobile}}</td>
                <td>{{$list->city}}</td>
                <td>{{$list->role}}</td>
                <td>{{$list->address}}</td>
                <td>{!!$list->status == 1 ? '<span class="badge badge-outline-success">Avtive</span>' : '<span class="badge badge-outline-warning">In Active</span>'!!}</td>
                
                <td>
                    <a href="user/{{$list->id}}/edit" class="btn btn-sm btn-outline-info"><span class="mdi mdi-pencil-box-outline"></span></a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    {{ $lists->appends($_GET)->links()}}
</div>
@endsection