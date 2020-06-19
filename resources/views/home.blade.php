@extends('layouts.app')
@section('titoloPagina', 'Dashboard')
@section('content')
{{-- questi sono i messaggi che compaiono in alto nella view /home quando modifico o elimino un post --}}
<br>
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    <br>
@endif
{{------------------------------------------------------------------------------------------------------}}
<br>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{route('posts.create')}}" class="btn btn-success">Crea un post</a>
                    <br>
                    <br>
                    <h3 class="text-center">I tuoi post</h3>
                    <br>
                    @if(count($posts) > 0)
                        <table class="table">
                            @foreach($posts as $post)
                                <tr>
                                    {{-- oppure --}}
                                    {{-- <th><a href="/posts/{{$post->id}}">{{$post->title}}</a></th> --}}
                                    <th><a href="{{route('posts.show', $post->id)}}"></a></th>
                                    {{-- oppure --}}
                                    {{-- <th><a href="/posts/{{$post->id}}/edit">{{$post->title}}</a></th> --}}
                                    <th><a class="btn btn-info" href="{{route('posts.edit', $post->id)}}">Modifica</a></th>
                                    <td>
                                        <form action="{{route('posts.destroy', $post->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input class="btn btn-danger" type="submit" value="Elimina">
                                          </form>
                                      </td>
                                    </td>
                                </tr>
                            @endforeach 
                        </table>
                    @else 
                      <p>Non ci sono post</p>  
                    @endif
                </div>
                
            </div>
            <br>
            {{$posts->links()}}
        </div>
    </div>
     
</div>


@endsection
