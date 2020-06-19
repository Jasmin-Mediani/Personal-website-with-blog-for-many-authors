@if(count($errors) > 0 )
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif


@if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif


{{-- sessione di messaggi per riuscita di modifica e eliminazione dei post --}}

@if(session('ok'))
<div class="alert alert-success">
    {{session('ok')}}
</div>
@endif

