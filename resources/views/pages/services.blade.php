@extends('layouts.app')
@section('titoloPagina', 'Servizi')
@section('content')
    <div class="jumbotron text-center">
        <h1>{{$titolo}}</h1> {{-- il titolo che si trova nella funzione pubblica services, in PagesController --}}
        <p class="text-center">Questa è la pagina services in resources/views/pages</p>
    </div>
        @if (count($servizi) > 0)
            <ul class="list-group">
                @foreach ($servizi as $servizio)
                    <li class="list-group-item">{{$servizio}}</li>
                @endforeach
            </ul>    
        @endif
        
@endsection