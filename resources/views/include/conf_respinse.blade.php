<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
            Session::forget('success');
            @endphp
        </div>
        @elseif(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
            @php
            Session::forget('error');
            @endphp
        </div>
        @endif
    </div>
</div>