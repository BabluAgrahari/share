<!-- Modal -->
<div class="modal fade" id="followUpModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

                    <div class="form-group">
                        <label>Follow Up Date</label>
                        <input type="date" name="follow_up_date" class="form-control form-control-sm">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" id="optionsRadios1" value="company"> Company <i class="input-helper"></i></label>
                            </div>
                            <select class="form-control form-control-sm" name="company_id" id="company" disabled>
                                <option value="">Select</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" id="optionsRadios2" value="agent">Agent<i class="input-helper"></i></label>
                            </div>
                            <select class="form-control form-control-sm" name="agent_id" id="agent" disabled>
                                <option value="">Select</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" id="optionsRadios3" value="court"> Court <i class="input-helper"></i></label>
                            </div>
                            <select class="form-control form-control-sm" name="court_id" id="court" disabled>
                                <option value="">Select</option>
                                @foreach($couts as $court)
                                <option value="{{$court->id}}">{{ucwords($court->court_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control" rows="3"></textarea>
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
                $('#court').attr('disabled', true);
                $('#agent').attr('disabled', true);
                $('#optionsRadios1').prop('checked', true);
                $('#optionsRadios3').prop('checked', false);
                $('#optionsRadios2').prop('checked', false);
            } else if (radio_val == 'agent') {
                $('#agent').attr('disabled', false);
                $('#company').attr('disabled', true);
                $('#court').attr('disabled', true);
                $('#optionsRadios1').prop('checked', false);
                $('#optionsRadios3').prop('checked', false);
                $('#optionsRadios2').prop('checked', true);
            } else if (radio_val == 'court') {
                $('#court').attr('disabled', false);
                $('#agent').attr('disabled', true);
                $('#company').attr('disabled', true);
                $('#optionsRadios1').prop('checked', false);
                $('#optionsRadios3').prop('checked', true);
                $('#optionsRadios2').prop('checked', false);
            }
        })

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