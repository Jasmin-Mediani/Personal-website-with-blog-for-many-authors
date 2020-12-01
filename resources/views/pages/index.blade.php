@extends('layouts.app')
@section('titoloPagina', 'Homepage')
@section('content')
    <div class="sezione sezione-home">
        {{-- <h1>{{$titolo}}</h1>  il titolo che si trova nella funzione pubblica index, in PagesController --}}
        {{-- <p class="text-center">Questa è la pagina index in resources/views/pages</p> --}}
        <div class="semi-hero"></div>
        <div class="testo-jumbo">
            <h2>We’re a <i>creative</i> studio for women who mean <i>business</i></h2>
            <h3>We visualize your brand's highest self – by design.</h3>
            <button><a href="{{route('services')}}">view services</a></button>
        </div>
    </div>
@endsection