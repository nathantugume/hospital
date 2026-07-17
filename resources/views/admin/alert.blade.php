@if(session()->has('message'))

<div class="alert alert-success">
    <button class="close" type="button" data-dismiss="alert">x</button>
    {{ session()->get('message') }}
</div>

@endif