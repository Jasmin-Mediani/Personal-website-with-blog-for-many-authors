@extends('layouts.app')
@section('titoloPagina', $post->title)
@section('content')  
    <div class="show-main">
        <div class="show-upper">
            <h2>{{$post->title}}</h2>
            <img class="show-image" src="/storage/cover_images/{{$post->cover_image}}" alt="">
            <div class="show-body">
                <p>{!! $post->body !!}</p>  {{-- per fare l'escape sulle formattazioni di ckeditor --}}
            </div>
        </div>
        <div class="show-lower">
        <p><small>creato in data: {{$post->created_at->format('d-m-Y')}} da <span class="nome-autore">{{$post->user->name}}</span></small></p>
            <div class="flex-buttons">
                <a href="{{route('posts.index')}}" class="btn btn-secondary">Indietro</a>
            
            @if(Auth::id() == $post->user->id)
                <a class="btn btn-info" href="{{route('posts.edit', $post->id)}}">Modifica</a>
            </div>
            @endif
        </div>
    </div>
@endsection
