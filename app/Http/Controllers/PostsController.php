<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
/* SENZA ELOQUENT) Per prendere i dati dal db si aggiunge use/DB */
use DB; 

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index' , 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        /******** METODO SENZA ELOQUENT, vecchia versione simile a sql ************/

        //$posts = DB::select('SELECT * FROM posts');

        
        /************* METODO CON ELOQUENT ********************/
        //$posts = Post::all();
        //$posts = Post::orderBy('created_at', 'desc')->take(1)->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        //return view('posts.index', compact('posts'));
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        
        //crea un post riempiendo i campi del form uno per uno (gli vanno detti):
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        // crea un post riempiendo i campi del form tutti insieme: 
        $data = $request->all(); //prende tutte le richieste contenute nel form...
        $post->fill($data);  //riempie tutti i campi...
        $post->save();

        return redirect('/home')->with('success', 'Post creato correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $post = Post::find($id);
        return view('posts.show', compact('post', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //controllo su proprietario del post
        if(auth()->user()->id !== $post->user->id) {
            return redirect('/posts')->with('error', 'Azione non autorizzata');
        };


        //return view('posts.edit')->with('post', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function update(Request $request, $id)  // NOTA: l'update è identica alla store, cambia solo che non voglio generare un new Post, ma selezionarlo per id.... quindi....  "$post = Post::find($id)" al posto di "$post = new Post". E poi cambia il messaggio dato all'utente (post MODIFICATO correttamente invece che "creato" correttamente).
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        
        //crea un post riempiendo i campi del form uno per uno (gli vanno detti):
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        // crea un post riempiendo i campi del form tutti insieme: 
        $data = $request->all(); //prende tutte le richieste contenute nel form...
        $post->fill($data);  //riempie tutti i campi...
        $post->save();

        //return redirect('/posts')->with('success', 'Post modificato correttamente');
        return redirect('/home')->with('success', 'Post modificato correttamente');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $post = Post::find($id);

        //controllo su proprietario del post
        if(auth()->user()->id !== $post->user->id) {
            return redirect('/posts')->with('error', 'Azione non autorizzata');
        };


        $post->delete();
        return redirect('/home')->with('success', 'Post eliminato correttamente');
    }



    // ESEMPIO DI API PER PASSARE I DATI A JAVASCRIPT (((IN QUESTO CASO NON SERVE PERCHE' LA CHIAMATA AI POST LA FACCIO GIA' LATO BACKEND MA E' COMUQUE UN ESEMPIO DI COME PASSARE I DATI))): 

    public function apiPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        /* per trasformare una collection in un array serve creare un array vuoto dove pushare i singoli post presi dalla collection:
        

        $arrayPosts= [];
        foreach ($posts as $post) {
            $arrayPosts[] = $post->toArray();
        } 
        dd($arrayPosts);
        

       ... oppure  ->toArray()  */

        $posts = Post::orderBy('created_at', 'desc')->get()->toArray();

        $postsPerJs = json_encode($posts);
        return $postsPerJs; 

        
    }
}
