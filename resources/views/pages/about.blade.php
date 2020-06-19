@extends('layouts.app')
@section('titoloPagina', 'About')
@section('content')
    <div class="jumbotron text-center">
        <h1>{{$titolo}}</h1>{{-- il titolo che si trova nella funzione pubblica about, in PagesController --}}
        <p class="text-center">Questa è la pagina about in resources/views/pages</p>
    </div>
    
@endsection