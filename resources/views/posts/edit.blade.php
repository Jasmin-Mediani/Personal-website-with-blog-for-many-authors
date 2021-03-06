@extends('layouts.app')
@section('titoloPagina', 'Modifica post')
@section('content')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>  {{-- guida per installare ckeditor in laravel 7:  https://ckeditor.com/docs/ckeditor4/latest/guide/dev_installation.html --}}
    <br>
    <div class="container">
        <h2>Modifica il post</h2>
        {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            @method('PATCH') <!--PATCH PER POTER MODIFICARE ANCHE LE IMMAGINI-->

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

            {{------------ FORM DEL CARICAMENTO DELL'IMMAGINE --------------}}
            
            <div class="edit-upload">
                <div class="form-group">   
                    
                    @if ($post->cover_image == "") 
                        <img class="anteprima-immagine-corrente invisible" src="/storage/cover_images/{{$post->cover_image}}" alt="" height="150px" width="130px">                    
                    @else 
                    <label for="delete-image"> Cancella l'immagine corrente </label>
                    <!-- TRICK: CHECKBOX SENTINELLA USATA COME BOTTONE PER CANCELLARE L'IMMAGINE CORRENTE --->
                    <!-- (vedi PostsController, funzione update)--->
                    <input type="checkbox" id="delete-image" name="delete-image" value="checked">
                        <img class="anteprima-immagine-corrente" src="/storage/cover_images/{{$post->cover_image}}" alt="" height="150px" width="130px"> 
                    @endif
                </div>
    
                <div class="form-group">
                    <input type="file" name="cover_image"> 
                    {{-- {{Form::file('cover_image')}} --}}
                </div>
            </div>


            {{------------------ FORM DEL TASTO SALVA -------------------}}

            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Salva">
            </div>
    </div>

        {!! Form::close() !!}  


        @if(Session::has('success'))
          <div class="alert alert-success">
              {{ Session::get('success') }}
          </div>
        @endif
       
@endsection
