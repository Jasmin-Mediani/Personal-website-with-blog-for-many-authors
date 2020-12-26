@extends('layouts.app')
@section('titoloPagina', 'Crea un post')
@section('content')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>  {{-- guida per installare ckeditor in laravel 7:  https://ckeditor.com/docs/ckeditor4/latest/guide/dev_installation.html --}}
    <br>
   <div class="container">
        <h2>Crea un post</h2>
        {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @csrf
        @method('POST')

        {{------------------ TITOLO -------------------}}

        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" class="form-control" id="title"  placeholder="Inserisci un titolo" name="title">
            
            @error('title')
            <div class="alert alert-danger">Il post deve avere un titolo</small>
            @enderror
            
        </div>

        {{------------------ TEXT AREA PER CORPO POST -------------------}}
        <div class="form-group">
            <label for="body">Contenuto del post</label>
            <textarea name="body" id="editor" rows="10" cols="80" class="form-control"></textarea>
            
            @error('body')
            <div class="alert alert-danger">Il post deve avere un contenuto</small>
            @enderror
            
            <script>
                CKEDITOR.replace( 'editor' );
            </script>
        </div>


        {{------------------ FORM DEL TASTO SALVA -------------------}}

        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Salva">
        </div>
   </div>

    {!! Form::close() !!}  
       
@endsection
