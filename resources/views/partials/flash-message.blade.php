@if (session('status'))
    <div class="lc-flash-message alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('status') }}
    </div>
@endif