@extends('layout.layout')
@section('content')

<div class="card-header py-2 h-body">
    <div class="row">
        <div class="col-md-6 pt-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit Client</h6>
        </div>

        <div class="col-md-6">
            <a href="{{url('client')}}" class="btn btn-warning btn-sm" style="float:right;"><span class="mdi mdi-backburger"></span>&nbsp;Back</a>
        </div>
    </div>
</div>

<div class="card-body h-body">
    <div class="row">
        <div class="col-md-12">

            <form action="{{url('client/'.$res->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <!-- <h6>Client Details</h6>
                    <hr> -->

                    <div class="form-group col-md-3">
                        <label>Image</label>
                        <input type="file" class="form-control form-control-sm" name="image">
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>File No</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('file_no')??$res->file_no}}" placeholder="Enter File No" name="file_no">
                        @error('file_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Folio No</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('folio_no')??$res->folio_no }}" placeholder="Enter Folio No" name="folio_no">
                        @error('folio_no')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Share Holder</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('share_holder')??$res->share_holder}}" placeholder="Enter Share Holder" name="share_holder">
                        @error('share_holder')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="form-group col-md-3">
                        <label>SRN</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('srn')??$res->srn}}" placeholder="Enter SRN" name="srn">
                        @error('srn')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> -->

                    <div class="form-group col-md-3">
                        <label>Survivor Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('survivor_name')??$res->survivor_name}}" placeholder=" Enter Survivor Name" name="survivor_name">
                        @error('survivor_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Date</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('date')??$res->date}}" placeholder="Enter Date" name="date">
                        @error('date')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Select Court</label>
                        <select class="form-control form-control-sm" placeholder="Enter Court Name" name="court_id">
                            <option value="">Select</option>
                            @foreach($courts as $list)
                            <option value="{{ $list->id }}" {{(old('court_id')==$list->id)?"selected":($list->id==$res->court_id?'selected':'')}}>{{ ucwords($list->court_name)}}</option>
                            @endforeach
                        </select>
                        @error('court_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label>City</label>
                        <input type="text" class="form-control form-control-sm" value="{{old('city')??$res->city}}" placeholder="Enter City" name="city">
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label value="">State</label>
                        <select class="form-control form-control-sm" placeholder="Enter State" name="state">
                            <option value=" ">Select</option>
                            @foreach(config('global.state') as $state)
                            <option value="{{$state}}" {{(old('state')==$state)?"selected":($state==$res->state?'selected':'')}}>{{$state}}</option>
                            @endforeach
                        </select>
                        @error('state')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label>Pin</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('pin')??$res->pin}}" placeholder="Enter Pin Code" name="pin">
                        @error('pin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-5">
                        <label>Address</label>
                        <textarea type="text" class="form-control form-control-sm" placeholder="Enter Address" name="address">{{ old('address')??$res->address}}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Remark</label>
                        <textarea name="remarks" class="form-control form-control-sm" placeholder="Enter Remark" rows="3">{{ old('remarks')??$res->remarks}}</textarea>
                    </div>
                </div>

                <div class="row">
                    <!-- <h6><i class="mdi mdi-account-circle menu-icon"></i>Contact Person Details</h6>
                    <hr> -->
                    <div class="form-group col-md-3">
                        <label>Contant Person Name</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_name')??$res->cp_name}}" name="cp_name" placeholder="Contact Person Name">
                        @error('cp_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Email</label>
                        <input type="email" class="form-control form-control-sm" value="{{ old('cp_email')??$res->cp_email}}" name="cp_email" placeholder="Enter Email" @readonly(Auth::user()->role !='admin')/>
                        @error('cp_email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Mobile</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_mobile')??$res->cp_phone}}" name="cp_mobile" placeholder="Enter Mobile" @readonly(Auth::user()->role !='admin')/>
                        @error('cp_mobile')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label>Designation </label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('cp_designation')??$res->cp_designation}}" placeholder=" Enter Designation" name="cp_designation">
                        @error('cp_designation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <!-- <h6>Company Details</h6> -->
                    <!-- <hr> -->
                    <div class="company-table">
                        <table class="table table-sm w-75">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Share Qty</th>
                                    <th>Type</th>
                                    <th>SRN</th>
                                    <th>Transfer Agent</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="field_wrapper">
                                @php $key = 1; $i=0; @endphp
                                @forelse($client_to_company as $key=>$val)
                                <tr id="row-{{$key}}">
                                    <td class="w-25">
                                        <select id="company_name" selector="{{$key}}" class="form-control form-control-xs" required name="company[{{$key}}][company_id]">
                                            <option value="">Select</option>
                                            @foreach($companies as $list)
                                            <option value="{{ $list->id }}" {{$val->company_id==$list->id?'selected':''}}>{{ ucwords($list->company_name)}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="w-25">
                                        <input type="number" class="form-control form-control-xs" name="company[{{$key}}][unit]" value="{{$val->unit}}" placeholder="Enter Unit">
                                    </td>

                                    <td class="w-25">
                                        <select class="form-control form-control-xs" required name="company[{{$key}}][type]">
                                            <option value="">Select</option>
                                            <option value="type1" {{$val->type =='type1'?'selected':''}}>Type1</option>
                                            <option value="type2" {{$val->type =='type2'?'selected':''}}>Type2</option>
                                            <option value="type3" {{$val->type =='type3'?'selected':''}}>Type3</option>
                                            <option value="type4" {{$val->type =='type4'?'selected':''}}>Type4</option>
                                            <option value="type5" {{$val->type =='type5'?'selected':''}}>Type5</option>
                                        </select>
                                    </td>

                                    <td class="w-25">
                                        <input type="text" class="form-control form-control-xs" value="{{$val->srn}}" placeholder="Enter SRN" name="company[{{$key}}][srn]">
                                    </td>

                                    <td class="w-25">
                                        <select class="form-control form-control-xs" id="agent-id-{{$key}}" required name="company[{{$key}}][agent_id]">
                                            <option value="">Select</option>

                                        </select>
                                        @push('script')
                                        <script>
                                            var key = '{{$key}}';
                                            $.ajax({
                                                url: "{{url('client/find-agent')}}/" + <?= $val->company_id ?>,
                                                data: {
                                                    'agent_id': <?= !empty($val->agent_id) ? $val->agent_id : '' ?>
                                                },
                                                type: "GET",
                                                dataType: "JSON",
                                                success: function(res) {

                                                    $('#agent-id-' + key).html(res);
                                                }
                                            })
                                        </script>
                                        @endpush
                                    </td>
                                    <td>
                                        @if($key <= 0) <a href="javascript:void(0)" id="add_more" class="btn btn-xs btn-success"><span class="mdi mdi-plus"></span></a>
                                            @else
                                            <a href="javascript:void(0)" onClick="removeRow('{{$key}}');" class="btn btn-xs btn-danger"><span class="mdi mdi-delete-forever"></span></a>
                                            @endif
                                    </td>
                                </tr>

                                <?php $i++ ?>
                                @empty
                                <?php $i = 1; ?>
                                <tr id="row-0">
                                    <td class="w-25">
                                        <select id="company_name" selector="0" class="form-control form-control-xs" required name="company[0][company_id]">
                                            <option value="">Select</option>
                                            @foreach($companies as $list)
                                            <option value="{{ $list->id }}">{{ ucwords($list->company_name)}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="w-25">
                                        <input type="number" class="form-control form-control-xs" required name="company[0][unit]" value="{{old('unit')}}" placeholder="Enter Unit">
                                    </td>

                                    <td class="w-25">
                                        <select class="form-control form-control-xs" required name="company[0][type]">
                                            <option value="">Select</option>
                                            <option value="type1">Type1</option>
                                            <option value="type2">Type2</option>
                                            <option value="type3">Type3</option>
                                            <option value="type4">Type4</option>
                                            <option value="type5">Type5</option>
                                        </select>
                                    </td>

                                    <td class="w-25">
                                        <input type="text" class="form-control form-control-xs" value="{{old('srn')}}" placeholder="Enter SRN" name="company[0][srn]">
                                    </td>

                                    <td class="w-25">
                                        <select class="form-control form-control-xs" id="agent-id-0" placeholder="Select Contant" required name="company[0][agent_id]">
                                            <option value="">Select</option>

                                        </select>
                                    </td>
                                    <td><a href="javascript:void(0)" id="add_more" class="btn btn-xs btn-success"><span class="mdi mdi-plus"></span></a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var i = '{{$i}}';
    $('#add_more').click(function() {
        var vendor_id = $(this).attr('vendor_id');
        var fieldHTML = `<tr id="row-${i}">
                                <td class="w-25">
                                    <select id="company_name" class="form-control form-control-xs" required selector="${i}" name="company[${i}][company_id]">
                                        <option value="">Select</option>
                                        @foreach($companies as $list)
                                        <option value="{{ $list->id }}">{{ ucwords($list->company_name)}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="w-25">
                                    <input type="number" class="form-control form-control-xs" required name="company[${i}][unit]" placeholder="Enter Qty">
                                </td>
                                <td class="w-25">
                                    <select class="form-control form-control-xs" required name="company[${i}][type]">
                                        <option value="">Select</option>
                                        <option value="type1">Type1</option>
                                        <option value="type2">Type2</option>
                                        <option value="type3">Type3</option>
                                        <option value="type4">Type4</option>
                                        <option value="type5">Type5</option>
                                    </select>
                                </td>
                                 <td class="w-25">
                                        <input type="text" class="form-control form-control-xs" placeholder="Enter SRN" name="company[${i}][srn]">
                                    </td>
                                <td class="w-25">
                                    <select class="form-control form-control-xs" id="agent-id-${i}" placeholder="Select Contant" required name="company[${i}][agent_id]">
                                        <option value="">Select</option>
                                    </select>
                                </td>
                                <td>
                                <a href="javascript:void(0)" onClick="removeRow(${i});" class="btn btn-xs btn-danger"><span class="mdi mdi-delete-forever"></span></a>
                                </td>
                            </tr>`;

        $('#field_wrapper').append(fieldHTML);
        i++;
    });

    function removeRow(id) {
        var element = document.getElementById("row-" + id);
        element.parentNode.removeChild(element);
    }

    $(document).on('change', '#company_name', function() {
        let company_id = $(this).val();
        let selector = $(this).attr('selector');
        $.ajax({
            url: "{{url('client/find-agent')}}/" + company_id,
            type: "GET",
            dataType: "JSON",
            success: function(res) {

                $('#agent-id-' + selector).html(res);
            }
        })
    });
</script>

@endpush