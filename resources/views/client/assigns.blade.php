<!-- Modal -->
<div class="modal fade" id="assignModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: -17px !important;">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="home" aria-selected="true">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#supervisor" role="tab" aria-controls="profile" aria-selected="false">Supervisor</a>
                    </li>
                </ul>
                <!-- <h5 class="modal-title" id="staticBackdropLabel">Assign Client</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="home-tab">
                        <form class="assign" id="staff" action="{{url('assign-user')}}" method="POST">
                            @csrf
                            <input type="hidden" class="client_id" name="client_id">
                            <table class="table table-sm">
                                <thead>
                                    <th>Name</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="staff-body">
                                </tbody>
                            </table>
                            <div class="form-group text-center mt-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="supervisor" role="tabpanel" aria-labelledby="profile-tab">
                        <form class="assign" type="supervisor" action="{{url('assign-user')}}" method="POST">
                            @csrf
                            <input type="hidden" class="client_id" name="client_id">
                            <table class="table table-sm">
                                <thead>
                                    <th>Name</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="supervisor-body">

                                </tbody>
                            </table>
                            <div class="form-group text-center mt-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.assignModal').click(function() {
            var client_id = $(this).attr('client_id');
            $.ajax({
                url: '{{url("assign-user")}}',
                type: 'GET',
                data: {
                    'client_id': client_id
                },
                dataType: 'JSON',
                success: function(res) {

                    $('#supervisor-body').html(res.supervisor);
                    $('#staff-body').html(res.staff);

                    $('.client_id').val(client_id);
                    $('#assignModal').modal('show');
                }
            })

        });


        /*start form submit functionality*/
        $("form.assign").submit(function(e) {
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