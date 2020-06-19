@extends('layouts.app')
@section('titoloPagina', 'Modifica post')
@section('content')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>  {{-- guida per installare ckeditor in laravel 7:  https://ckeditor.com/docs/ckeditor4/latest/guide/dev_installation.html --}}
    <br>
    <h2>Modifica il post</h2>
        {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST']) !!}
            @csrf
            @method('PUT')

            {{------------------ TITOLO -------------------}}

            <div class="form-group">
                <label for="title">Titolo</label>
            <input type="text" class="form-control" id="title"  placeholder="Inserisci un titolo" name="title" value="{{$post->title}}">
                
                @error('title')
                <div class="alert alert-danger">Il post deve avere un titolo</small>
                @enderror
                
            </div>

            {{------------------ TEXT AREA PER CORPO POST -------------------}}
            <div class="form-group">
                <label for="body">Testo</label>
            <textarea name="body" id="editor" rows="10" cols="80" class="form-control">{{$post->body}}</textarea>
                
                @error('body')
                <div class="alert alert-danger">Il post deve avere un contenuto</small>
                @enderror
                
                <script>
                    CKEDITOR.replace( 'editor' );
                </script>
            </div>


            {{------------------ FORM DEL TASTO SALVA -------------------}}

            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Salva">
            </div>

        {!! Form::close() !!}  


        @if(Session::has('success'))
          <div class="alert alert-success">
              {{ Session::get('success') }}
          </div>
        @endif
       
@endsection
