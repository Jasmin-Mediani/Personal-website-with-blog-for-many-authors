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
          {{-- <th>ID</th> --}}
          <th>Titolo</th>
          <th>Autore</th>
          {{-- <th colspan="3">Actions</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $post)
          <tr>
            {{-- <td>{{$post['id']}}</td> --}}
          <td><a href="{{route('posts.show', $post['id'])}}">{{$post->title}}</a></td>
          <td>{{$post->user->name}}</td>
         {{--  <td><a class="btn btn-primary" href="{{route('posts.show', $post['id'])}}">Visualizza</a> </td> --}}
          {{-- <td>
            @if(Auth::id() == $post['user_id'])
            <a class="btn btn-info" href="{{route('posts.edit', $post->id)}}">Modifica</a>
            @endif
          </td> --}}
            {{-- <td>
            <form action="{{route('posts.destroy', $post['id'])}}" method="POST">
                @csrf
                @method('DELETE')
                @if(Auth::id() == $post['user_id'])
                <input class="btn btn-danger" type="submit" value="Elimina">
                @endif
              </form>
            </td> --}}
          </tr>
        @endforeach
      </tbody>
    </table>
    @else 
      <p>Non ci sono post</p>
    @endif

    {{$posts->links()}}

@endsection