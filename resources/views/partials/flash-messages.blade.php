@if (session('status'))
    <div class="lc-successful-message alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('status') }}
    </div>
@endif

@error('general')
    <div class="lc-error-message alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       {{ $message }}
    </div>
@enderror