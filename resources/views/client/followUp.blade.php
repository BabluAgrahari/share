<!-- Modal -->
<div class="modal fade" id="followUpModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Follow Up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="follow-up" action="{{url('follow-up')}}" method="post">
                    @csrf
                    <input type="hidden" class="client_id" name="client_id">

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label>Follow Up Date</label>
                            <input type="date" name="follow_up_date" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6"></div>

                        <div class="form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" id="optionsRadios1" value="company"> Company <i class="input-helper"></i></label>
                            </div>
                            <select class="form-control form-control-xs select_field" ref_by="copmany" name="company_id" id="company" disabled>
                                <option value="">Select</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" id="optionsRadios2" value="agent">Agent<i class="input-helper"></i></label>
                            </div>
                            <select class="form-control form-control-xs select_field" ref_by="agent" name="agent_id" id="agent" disabled>
                                <option value="">Select</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" id="optionsRadios3" value="court"> Court <i class="input-helper"></i></label>
                            </div>
                            <select class="form-control form-control-xs select_field" ref_by="court" name="court_id" id="court" disabled>
                                <option value="">Select</option>
                                @foreach($couts as $court)
                                <option value="{{$court->id}}">{{ucwords($court->court_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="customer_person"></div>
                    <div id="add-new-cp"></div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Enter Remarks"></textarea>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.followUpModal').click(function() {
            var client_id = $(this).attr('client_id');

            $.ajax({
                url: '{{url("find-company")}}',
                type: 'GET',
                data: {
                    'client_id': client_id
                },
                dataType: 'JSON',
                success: function(res) {

                    $('#company').html(res.company);
                    $('#agent').html(res.agent);
                    $('.client_id').val(client_id);
                    $('#followUpModal').modal('show');
                }
            })

        })


        $('.form-check-input').click(function() {
            var radio_val = $(this).val();
            if (radio_val == 'company') {
                $('#company').attr('disabled', false);
                $('#court').attr('disabled', true).val('');
                $('#agent').attr('disabled', true).val('');
                $('#optionsRadios1').prop('checked', true);
                $('#optionsRadios3').prop('checked', false);
                $('#optionsRadios2').prop('checked', false);
            } else if (radio_val == 'agent') {
                $('#agent').attr('disabled', false);
                $('#company').attr('disabled', true).val('');
                $('#court').attr('disabled', true).val('');
                $('#optionsRadios1').prop('checked', false);
                $('#optionsRadios3').prop('checked', false);
                $('#optionsRadios2').prop('checked', true);
            } else if (radio_val == 'court') {
                $('#court').attr('disabled', false);
                $('#agent').attr('disabled', true).val('');
                $('#company').attr('disabled', true).val('');
                $('#optionsRadios1').prop('checked', false);
                $('#optionsRadios3').prop('checked', true);
                $('#optionsRadios2').prop('checked', false);
            }
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

            <div class="form-group col-md-6">
            <input type="text" required name="name" id="name" class="form-control form-control-xs" placeholder="Enter Name">
            </div>

            <div class="form-group col-md-6">
            <input type="email" required name="email" id="email" class="form-control form-control-xs" placeholder="Enter Email">
            </div>

            <div class="form-group col-md-4">
            <input type="number" required name="mobile" id="mobile" class="form-control form-control-xs" placeholder="Enter Phone">
            </div>

            <div class="form-group col-md-6">
            <input type="text" name="designation" id="designation" class="form-control form-control-xs" placeholder="Enter Designation">
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
                        $('form.assign')[0].reset();
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