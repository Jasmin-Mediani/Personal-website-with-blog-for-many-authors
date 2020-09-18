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
            <small>creato in data: {{$post->created_at->format('d-m-Y')}}</small>
            <a href="{{route('posts.index')}}" class="btn btn-secondary">Indietro</a>
        </div>
    </div>
@endsection
