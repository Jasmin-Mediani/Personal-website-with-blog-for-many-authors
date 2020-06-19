@extends('layouts.app')
@section('titoloPagina', 'Blog post')
@section('content')           
    <br>
    <br>
    <h2>{{$post->title}}</h2>
    <div>
        <p>{!! $post->body !!}</p>  {{-- per fare l'escape sulle formattazioni di ckeditor --}}
    </div>
    <br>
    <small>creato in data: {{$post->created_at}}</small>

    <br>
    <br>
    <br>

    <a href="{{route('posts.index')}}" class="btn btn-secondary">Indietro</a>
@endsection
