@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        {{$message}}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        {{$message}}
    </div>
@endif

{{-- untuk js --}}
<div id="AlertSuccessJs" class="alert alert-success" role="alert" style="display: none">    
</div>

<div id="AlertErrorJs" class="alert alert-danger" role="alert" style="display: none">    
</div>