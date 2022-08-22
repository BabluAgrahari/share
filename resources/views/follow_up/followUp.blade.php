<!-- Modal -->
<style>
    span.select2-container--default {
        width: 100% !important;
    }
</style>
<div class="modal fade" id="followUpModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: -17px !important;">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#staff1" role="tab" aria-controls="home" aria-selected="true">
                            <h5 class="modal-title" id="staticBackdropLabel">Follow Up</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#supervisor1" role="tab" aria-controls="profile" aria-selected="false">
                            <h5 class="modal-title" id="staticBackdropLabel">Old Follow Up</h5>
                        </a>
                    </li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="staff1" role="tabpanel" aria-labelledby="home-tab">

                        <form id="follow-up" action="{{url('follow-up')}}" method="post">
                            @csrf
                            <input type="hidden" class="client_id" name="client_id">

                            <div class="row">

                                <div class="form-group col-md-4">
                                    <div class="mt-4"><span class="client_name"></span></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Follow Up Date</label>
                                    <input type="date" name="follow_up_date" class="form-control form-control-sm">
                                    <span class="text-danger" id="follow_up_date_msg"></span>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-3">
                                    <div class="form-check" style="margin:0px !important; padding:0px !important">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="follow_up_for" id="optionsRadios2" value="follow_up_user"><i class="input-helper"></i>Select User</label>
                                    </div>
                                    <select name="with_user_id" class="form-control form-control-sm" disabled id="follow_up_user">
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{ucwords($user->name)}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="with_user_id_msg"></span>
                                    <span class="text-danger" id="follow_up_for_msg"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-check" style="margin:0px !important; padding:0px !important">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="follow_up_for" id="optionsRadios1" value="follow_up_with"><i class="input-helper"></i>Follow Up With</label>
                                    </div>
                                    <select name="type[]" class="form-control form-control-sm" multiple="multiple" id="follow_up_with" disabled>
                                        <!-- <option value="">Select</option> -->
                                        <option value="company">Company</option>
                                        <option value="agent">Agent</option>
                                        <option value="court">Court</option>
                                        <!-- <option value="client">Client</option> -->
                                    </select>
                                    <span class="text-danger" id="type_msg"></span>
                                </div>


                                <div class="form-group col-md-4 mt-4">
                                    <select class="mb-1 form-control form-control-sm select_field d-none" ref_by="company" name="company_id" id="company" disabled>
                                        <option value="">Select Company</option>
                                    </select>
                                    <span class="text-danger" id="company_id_msg"></span>

                                    <select class="mb-1 form-control form-control-sm select_field d-none" ref_by="agent" name="agent_id" id="agent" disabled>
                                        <option value="">Select Agent</option>
                                    </select>
                                    <span class="text-danger" id="agent_id_msg"></span>

                                    <select class="mb-1 form-control form-control-sm select_field d-none" ref_by="court" name="court_id" id="court" disabled>
                                        <option value="">Select Court</option>
                                    </select>
                                    <span class="text-danger" id="court_id_msg"></span>

                                    <select class="form-control form-control-sm select_field d-none" ref_by="client" name="client_id" id="client" disabled>
                                        <option value="">Select</option>
                                        @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{ucwords($client->share_holder)}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="client_id_msg"></span>
                                </div>
                            </div>

                            <div id="cp-div">
                                <div id="contact-person-company"></div>
                                <span class="text-danger" id="company_cp_id_msg"></span>
                                <div id="new-cp-company"></div>

                                <div id="contact-person-agent"></div>
                                <span class="text-danger" id="agent_cp_id_msg"></span>
                                <div id="new-cp-agent"></div>

                                <div id="contact-person-court"></div>
                                <div id="new-cp-court"></div>
                                <span class="text-danger" id="court_cp_id_msg"></span>
                            </div>

                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3" placeholder="Enter Remarks"></textarea>
                                <span class="text-danger" id="remarks_msg"></span>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="supervisor1" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="text-right"><span class="client_name"></span></div>
                        <div id="follow-up-list">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.followUpModal').click(function() {
            var client_id = $(this).attr('client_id');
            var client_name = $(this).attr('client_name');
            $("#follow_up_with").select2({
                dropdownParent: $("#followUpModal")
            });

            $.ajax({
                url: '{{url("find-company")}}',
                type: 'GET',
                data: {
                    'client_id': client_id
                },
                dataType: 'JSON',
                success: function(res) {
                    let follow_up_list = followUpList(res.follow_up_list);
                    $('#follow-up-list').html(follow_up_list);
                    $('#company').html(res.company);
                    $('#agent').html(res.agent);
                    $('#court').html(res.court);
                    $('.client_id').val(client_id);
                    $('.client_name').html(`<b>Client Name -&nbsp;</b>${client_name}`);
                    $('#followUpModal').modal('show');

                }
            });

        });

        function followUpList(lists) {
            var record = '';
            $.each(lists, (index, value) => {
                record += `
            <div id="accordion${index}" class="mb-1">
            <div class="card">
                <div class="card-header" id="heading${index}">
                <h3 class="mb-0">
                    <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse${index}" aria-expanded="true" aria-controls="collapseOne" style="font-size:14px !important;">
                    ${index.toUpperCase()}
                    </button>
                </h3 >
                </div>

                <div id="collapse${index}" class="collapse" aria-labelledby="heading${index}" data-parent="#accordion${index}">
                <div class="card-body" style="padding:0px !important;">
                    <table class="table table-hover">
                    <tr>
                    <th>Follow Up Date</th>
                    <th>Remarks</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>CP Name</th>
                    </tr>`;
                var tr = '';
                $.each(value, (ind, val) => {
                    tr += `<tr>
                           <td>${val.follow_up_date}</td>
                           <td class="w-25">${val.remarks}</td>
                           <td>${val.user_name}</td>
                           <td>${val.status}</td>
                           <td>${val.cp_name}</td>
                           </tr>`;
                });
                record += `${tr}</table>
                </div>
                </div>
            </div>
            </div>
            </div> `;
            })
            return record;

        }

        $(document).on('change', '#follow_up_with', function() {
            var type = $(this).val();
            var arrayType = type.toString().split(',');

            $('#company').attr('disabled', true).addClass('d-none');
            $('#court').attr('disabled', true).val('').addClass('d-none');
            $('#agent').attr('disabled', true).val('').addClass('d-none');
            $('#client').attr('disabled', true).addClass('d-none');

            if (arrayType.indexOf('company') !== -1)
                $('#company').attr('disabled', false).removeClass('d-none');

            if (arrayType.indexOf('agent') !== -1)
                $('#agent').attr('disabled', false).removeClass('d-none');

            if (arrayType.indexOf('court') !== -1)
                $('#court').attr('disabled', false).removeClass('d-none');

            if (arrayType.indexOf('client') !== -1)
                $('#client').attr('disabled', false).removeClass('d-none');

            $('#cp-form').remove().fadeOut('slow');
        })

        $('.select_field').change(function() {
            var id = $(this).val();
            var ref_by = $(this).attr('ref_by');
            showCP(id, ref_by);
        });

        function showCP(id, ref_by) {
            $.ajax({
                url: '{{url("find-contact-person")}}',
                type: 'GET',
                data: {
                    'ref_id': id,
                    'ref_by': ref_by
                },
                dataType: 'JSON',
                success: function(res) {
                    $('#contact-person-' + res.type).html(res.record);
                    // $('#add-new-btn').removeClass('d-none');
                }
            });
        }

        $(document).on('click', '.add-new', function() {

            let ref_id = $(this).attr('ref_id');
            let ref_by = $(this).attr('ref_by');
            $(this).hide();
            $('#new-cp-' + ref_by).show();

            $('#new-cp-' + ref_by).html(`<div id="${ref_by}">
             <div id="error_msg" class="text-danger"></div>
            <input type="hidden" class="token" id="token" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" class="ref_id" id="ref_id" value="${ref_id}" name="ref_id">
            <input type="hidden" class="ref_by" id="ref_by" value="${ref_by}" name="ref_by">
            <div class="row">

            <div class="form-group col-md-3 pr-1">
            <input type="text" name="designation" id="designation" class="form-control form-control-xs designation" placeholder="Enter Designation">
            </div>

            <div class="form-group col-md-3 pl-1 pr-1">
            <input type="text" required name="name" id="name" class="form-control form-control-xs name" placeholder="Enter Name">
            </div>

            <div class="form-group col-md-3 pl-1 pr-1">
            <input type="email" required name="email" id="email" class="form-control form-control-xs email" placeholder="Enter Email">
            </div>

            <div class="form-group col-md-3 pl-1">
            <input type="number" required name="mobile" id="mobile" class="form-control form-control-xs mobile" placeholder="Enter Phone">
            </div>

            <div class="form-group col-md-2 d-flex">
           <button class="btn btn-sm btn-outline-success save-cp" ref_by="${ref_by}" id="save-cp-${ref_by}">save</button>
           <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning cancel" ref_by="${ref_by}" id="cancel">Cancel</a>
            </div>

            </div>
            </div>`);

        });

        $(document).on('click', '.cancel', function() {
            let ref_by = $(this).attr('ref_by');
            $('#new-cp-' + ref_by).hide();
            $('#add-btn-' + ref_by).show();
        })

        /*start form submit functionality*/
        $(document).on('click', '.save-cp', function(e) {
            e.preventDefault();

            var ref_by = $(this).attr('ref_by');
            var selector = $(this).closest('#' + ref_by);

            formData = {
                '_token': selector.find('.token').val(),
                'ref_id': selector.find('.ref_id').val(),
                'ref_by': selector.find('.ref_by').val(),
                'name': selector.find('.name').val(),
                'email': selector.find('.email').val(),
                'mobile': selector.find('.mobile').val(),
                'designation': selector.find('.designation').val()
            };
            var url = '{{url("save-cp")}}';
            $.ajax({
                data: formData,
                type: "POST",
                url: url,
                dataType: 'json',
                beforeSend: function() {
                    $('#save-cp-' + ref_by).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Saving...`).attr('disabled', true);
                    $('#' + ref_by + ' input').attr('disabled', true);
                },
                success: function(res) {
                    /*Start Status message*/
                    if (res.status == 'error') {
                        $('#error_msg').html(`<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> ${res.msg}
                        </div>`);
                        $('#save-cp-' + ref_by).html(`Save`).attr('disabled', false);
                        $('#' + ref_by + ' input').attr('disabled', false);
                    }
                    /*End Status message*/

                    //for reset all field
                    if (res.status == 'success') {
                        $('#save-cp-' + ref_by).html(`Save`).attr('disabled', false);
                        selector.remove().fadeOut('slow');
                        $('#add-btn-' + ref_by).show();
                        showCP(selector.find('.ref_id').val(), selector.find('.ref_by').val());
                    }
                }
            });
        });
        /*end form submit functionality*/


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
                    $('#save-btn').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Saving...`).attr('disabled', true);
                },
                success: function(res) {
                    $('#save-btn').html(`Save`).attr('disabled', false);

                    $('.text-danger').html('');
                    if (res.validation) {
                        $('#follow_up_date_msg').html(res.validation.follow_up_date);
                        $('#follow_with_msg').html(res.validation.type);
                        $('#with_user_id_msg').html(res.validation.with_user_id);
                        $('#follow_up_for_msg').html(res.validation.follow_up_for);

                        if (res.validation.company_id) {
                            $('#company_id_msg').html(res.validation.company_id);
                            $('#company_cp_id_msg').html(res.validation.company_cp_id);
                        }
                        if (res.validation.court_id) {
                            $('#court_id_msg').html(res.validation.court_id);
                            $('#court_cp_id_msg').html(res.validation.court_cp_id);
                        }
                        if (res.validation.agent_id) {
                            $('#agent_id_msg').html(res.validation.agent_id);
                            $('#agent_cp_id_msg').html(res.validation.agent_cp_id);
                        }
                        $('#type_msg').html(res.validation.type);
                        $('#remarks_msg').html(res.validation.remarks);
                    }
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
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1000)
                    }
                }
            });
        });
        /*end form submit functionality*/

        $('#followUpModal').on('hidden.bs.modal', function() {
            location.reload();
        });

        $('.form-check-input').click(function() {

            let ref = $(this).val();
            if (ref == 'follow_up_user') {
                $('#follow_up_user').attr('disabled', false);
                $('#follow_up_with').attr('disabled', true).attr('selected', false);
                $('.select_field').hide();
                $('#cp-div').hide();
            } else if (ref == 'follow_up_with') {
                $('#follow_up_user').attr('disabled', true);
                $('#follow_up_with').attr('disabled', false);
                $('.select_field').show();
                $('#cp-div').show();
            }
        });
    })
</script>