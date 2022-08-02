@push('modal')

<!-- Modal -->
<div class="modal fade" id="assignModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#staff" role="tab" aria-controls="home" aria-selected="true">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#supervisor" role="tab" aria-controls="profile" aria-selected="false">Supervisor</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="staff" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>

                                @forelse($staffs as $key=>$staff)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{ucwords($staff->name)}}</td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <label class="form-check-label">
                                                <input type="checkbox" value="{{$staff->id}}" class="form-check-input" checked=""><i class="input-helper"></i></label>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Not Found Any Record.</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="supervisor" role="tabpanel" aria-labelledby="profile-tab">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>

                                @forelse($supervisors as $key=>$list)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{ucwords($list->name)}}</td>
                                    <td>
                                        <div class="form-check form-check-success">
                                            <label class="form-check-label">
                                                <input type="checkbox" value="{{$list->id}}" class="form-check-input" checked=""><i class="input-helper"></i></label>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Not Found Any Record.</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.assignModal').click(function() {

                $('#assignModal').modal('show');
            })
        })
    </script>
    @endpush