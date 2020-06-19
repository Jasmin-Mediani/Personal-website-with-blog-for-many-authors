@extends('layouts.app')
@section('titoloPagina', 'Homepage')
@section('content')
    <div class="jumbotron text-center">
        <h1>{{$titolo}}</h1>  {{-- il titolo che si trova nella funzione pubblica index, in PagesController --}}
        <p class="text-center">Questa è la pagina index in resources/views/pages</p>
    </div>
@endsection