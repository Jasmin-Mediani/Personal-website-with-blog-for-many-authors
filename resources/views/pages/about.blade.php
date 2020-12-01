@extends('layouts.app')
@section('titoloPagina', 'About')
@section('content')
    <div class="contenitore-about">
        {{-- <h1>{{$titolo}}</h1>il titolo che si trova nella funzione pubblica about, in PagesController --}}
        {{-- <p class="text-center">Questa è la pagina about in resources/views/pages</p> --}}

        
        <div class="about-wrapper">
            <div class="testo-about">
                <h2>I believe design should be based on Genuine Connection</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero rerum quae deleniti! Aut nostrum, veniam cumque incidunt itaque minus accusamus ipsum. Commodi accusamus aliquam, vitae quod voluptatem in vero tempore libero qui beatae itaque perspiciatis minus asperiores temporibus quibusdam aliquid laborum autem explicabo provident fugit porro sint quam. Adipisci ducimus repellat tenetur voluptatem maiores distinctio sapiente reiciendis corrupti. </p>
                <button>Yes, girl!</button>
            </div>
            <div class="foto-autore">
                <img src="immagini/tazze.jpg" alt="">
            </div>
        </div>
    </div>
    
@endsection