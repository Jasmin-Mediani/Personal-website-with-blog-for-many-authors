<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index() /* per mettere il titolo o altri elementi a una pagina si possono usare diversi metodi: */
    {
        /*metodo 1)*/ 
        $titolo = "Homepage";
         return view('pages.index', compact('titolo'));       //la pagina index.blade.php in resources/views/pages ha  {{$titolo}}
        
    }

    public function about()
    {
        /* metodo 2) */
        $title = "About";
        return view('pages.about')->with('titolo', $title);    //la pagina about.blade.php in resources/views/pages. 'titolo' è il nome che avrà la variabile nell'html{{$titolo}}, mentre $title è la variabile che ho scritto qui in controller - quella che deve prendere. Cioé {{$titolo}} lato html corrisponde a questo $title".
    }

    public function services()
    {
        
        /* metodo 3) */ 
            $data = array (
            'titolo' => 'Trattamenti',
            'servizi' => ['Trattamento n° 1', 'Trattamento n° 2', 'Trattamento n° 3']
            );
            
        return view('pages.services')->with($data); //la pagina services che si trova nella cartella pages, in resources. Al momento del return della view, se uso ->with() e passo un array, quando vado nella view/html ho già accesso all'interno dell'array. Devo solo decidere quale chiave usare... foreach servizi as servizio... <li> {{servizio}} </li> mi restituisce direttamente i servizi messi in lista. 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
