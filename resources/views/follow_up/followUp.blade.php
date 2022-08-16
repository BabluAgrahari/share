<!-- Modal -->
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
                        <div class="text-right"><span class="client_name"></span></div>
                        <form id="follow-up" action="{{url('follow-up')}}" method="post">
                            @csrf
                            <input type="hidden" class="client_id" name="client_id">

                            <div class="row">

                                <div class="form-group col-md-5">
                                    <label>Follow Up Date</label>
                                    <input type="date" name="follow_up_date" class="form-control form-control-sm">
                                    <span class="text-danger" id="follow_up_date_msg"></span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Follow Up With</label>
                                    <select name="type" class="form-control form-control-sm" id="follow_with">
                                        <option value="">Select</option>
                                        <option value="company">Company</option>
                                        <option value="agent">Agent</option>
                                        <option value="court">Court</option>
                                        <!-- <option value="client">Client</option> -->
                                    </select>
                                    <span class="text-danger" id="follow_with_msg"></span>
                                </div>

                                <div class="form-group col-md-4 mt-4">
                                    <select class="form-control form-control-sm select_field d-none" ref_by="copmany" name="company_id" id="company" disabled>
                                        <option value="">Select</option>
                                    </select>

                                    <select class="form-control form-control-sm select_field d-none" ref_by="agent" name="agent_id" id="agent" disabled>
                                        <option value="">Select</option>
                                    </select>

                                    <select class="form-control form-control-sm select_field d-none" ref_by="court" name="court_id" id="court" disabled>
                                        <option value="">Select</option>

                                    </select>

                                    <select class="form-control form-control-sm select_field d-none" ref_by="client" name="client_id" id="client" disabled>
                                        <option value="">Select</option>
                                        @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{ucwords($client->share_holder)}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="cp_msg"></span>
                                </div>
                            </div>

                            <div id="customer_person"></div>
                            <span class="text-danger" id="cp_id_msg"></span>
                            <div id="add-new-cp"></div>

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
            })

        })

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

        $(document).on('change', '#follow_with', function() {
            let type = $(this).val();

            if (type == 'company') {
                $('#company').attr('disabled', false).removeClass('d-none');
                $('#court').attr('disabled', true).val('').addClass('d-none');
                $('#agent').attr('disabled', true).val('').addClass('d-none');
                $('#client').attr('disabled', true).addClass('d-none');
            } else if (type == 'agent') {
                $('#agent').attr('disabled', false).removeClass('d-none');
                $('#company').attr('disabled', true).val('').addClass('d-none');
                $('#court').attr('disabled', true).val('').addClass('d-none');
                $('#client').attr('disabled', true).addClass('d-none');
            } else if (type == 'court') {
                $('#court').attr('disabled', false).removeClass('d-none');
                $('#agent').attr('disabled', true).val('').addClass('d-none');
                $('#company').attr('disabled', true).val('').addClass('d-none');
                $('#client').attr('disabled', true).addClass('d-none');
            } else if (type == 'client') {
                $('#court').attr('disabled', true).addClass('d-none');
                $('#agent').attr('disabled', true).val('').addClass('d-none');
                $('#company').attr('disabled', true).val('').addClass('d-none');
                $('#client').attr('disabled', false).removeClass('d-none');

            }
            $('#cp-form').remove().fadeOut('slow');
        })


        // $('.form-check-input').click(function() {
        //     var radio_val = $(this).val();
        //     if (radio_val == 'company') {
        //         $('#company').attr('disabled', false);
        //         $('#court').attr('disabled', true).val('');
        //         $('#agent').attr('disabled', true).val('');
        //         $('#optionsRadios1').prop('checked', true);
        //         $('#optionsRadios3').prop('checked', false);
        //         $('#optionsRadios2').prop('checked', false);
        //     } else if (radio_val == 'agent') {
        //         $('#agent').attr('disabled', false);
        //         $('#company').attr('disabled', true).val('');
        //         $('#court').attr('disabled', true).val('');
        //         $('#optionsRadios1').prop('checked', false);
        //         $('#optionsRadios3').prop('checked', false);
        //         $('#optionsRadios2').prop('checked', true);
        //     } else if (radio_val == 'court') {
        //         $('#court').attr('disabled', false);
        //         $('#agent').attr('disabled', true).val('');
        //         $('#company').attr('disabled', true).val('');
        //         $('#optionsRadios1').prop('checked', false);
        //         $('#optionsRadios3').prop('checked', true);
        //         $('#optionsRadios2').prop('checked', false);
        //     }
        //     $('#cp-form').remove().fadeOut('slow');
        // })

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
                    $('#customer_person').html(res.record);
                }
            });
        }

        $(document).on('click', '#add-new', function() {

            let ref_id = $('#add-new').attr('ref_id');
            let ref_by = $('#add-new').attr('ref_by');
            $('#add-new-btn').hide();

            $('#add-new-cp').html(`<div id="cp-form">
             <div id="error_msg" class="text-danger"></div>
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" id="ref_id" value="${ref_id}" name="ref_id">
            <input type="hidden" id="ref_by" value="${ref_by}" name="ref_by">
            <div class="row">

            <div class="form-group col-md-3 pr-1">
            <input type="text" name="designation" id="designation" class="form-control form-control-xs" placeholder="Enter Designation">
            </div>

            <div class="form-group col-md-3 pl-1 pr-1">
            <input type="text" required name="name" id="name" class="form-control form-control-xs" placeholder="Enter Name">
            </div>

            <div class="form-group col-md-3 pl-1 pr-1">
            <input type="email" required name="email" id="email" class="form-control form-control-xs" placeholder="Enter Email">
            </div>

            <div class="form-group col-md-3 pl-1">
            <input type="number" required name="mobile" id="mobile" class="form-control form-control-xs" placeholder="Enter Phone">
            </div>

            <div class="form-group col-md-2">
           <button class="btn btn-sm btn-outline-success" id="save-cp">
          save</button>
            </div>

            </div>
            </div>`);

        });

        /*start form submit functionality*/
        $(document).on('click', '#save-cp', function(e) {

            e.preventDefault();
            formData = {
                '_token': $('#token').val(),
                'ref_id': $('#ref_id').val(),
                'ref_by': $('#ref_by').val(),
                'name': $('#name').val(),
                'email': $('#email').val(),
                'mobile': $('#mobile').val(),
                'designation': $('#designation').val()
            };
            var url = '{{url("save-cp")}}';
            $.ajax({
                data: formData,
                type: "POST",
                url: url,
                dataType: 'json',
                beforeSend: function() {
                    $('#save-cp').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Saving...`).attr('disabled', true);
                    $('#cp-form input').attr('disabled', true);
                },
                success: function(res) {
                    /*Start Status message*/
                    if (res.status == 'error') {
                        $('#error_msg').html(`<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> ${res.msg}
                        </div>`);
                        $('#save-cp').html(`Save`).attr('disabled', false);
                        $('#cp-form input').attr('disabled', false);
                    }
                    /*End Status message*/

                    //for reset all field
                    if (res.status == 'success') {
                        showCP($('#ref_id').val(), $('#ref_by').val());
                        $('#save-cp').html(`Save`).attr('disabled', false);
                        $('#cp-form').remove().fadeOut('slow');
                        $('#add-new-btn').show();
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
                        if (res.validation.company_id) {
                            var cp_msg = res.validation.company_id;
                        } else if (res.validation.court_id) {
                            var cp_msg = res.validation.court_id;
                        } else if (res.validation.agent_id) {
                            var cp_msg = res.validation.agent_id;
                        }
                        $('#cp_msg').html(cp_msg);
                        $('#cp_id_msg').html(res.validation.cp_id);
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
                        setTimeout(function() {
                            location.reload();
                        }, 1000)
                    }
                }
            });
        });
        /*end form submit functionality*/
    })
</script>