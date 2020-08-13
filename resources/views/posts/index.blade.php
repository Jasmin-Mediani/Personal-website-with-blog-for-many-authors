@extends('layouts.app')
@section('titoloPagina', 'Blog')
@section('content')

  {{-- questi sono i messaggi che compaiono in alto nella view / quando modifico o elimino un post --}}
    
    <br>
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    <br>
  @endif

  {{------------------------------------------------------------------------------------------------------}}

    @if(count($posts) > 0 )
    <br>
    <br>
    <table class="table">
      <thead class="thead-dark ">
        <tr>
          <th>Titolo</th>
          <th>Autore</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $post)
          <tr>
          <td><a href="{{route('posts.show', $post['id'])}}">{{$post->title}}</a></td>
          <td>{{$post->user->name}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    @else 
      <p>Non ci sono post</p>
    @endif

    {{$posts->links()}}

@endsection