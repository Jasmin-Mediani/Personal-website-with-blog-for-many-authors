<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'cover_image' => 'image|nullable|max:1999' //NOTA: nullable a 'cover_image' l'avrei già messo in create_posts_table...  NOTA2: nella maggior parte dei server apache la dimensione massima consentita è 2MB (2000) per le immagini, quindi se non lo imposto ci sta che possa dare problemi. 
        ]);
        
        // Gestione dell'Upload del File
        if($request->hasFile('cover_image')) {
            // ottenere il nome del file con estensione
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //ottenere solo il nome del file
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);   //pathinfo() estrae il nome senza estenzione, è PHP puro
            //ottenere solo l'estensione
            $extension = $request->file('cover_image')->getClientOriginalExtension(); 
            //Nome del file da salvare
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Upload dell'immagine
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);  //crea una cartella in storage/app/public che si chiama 'public images' e ci salva l'immagine col nome appena costruito.
        } else {
            $fileNameToStore = 'noimage.jpg';  //se l'utente non uppa un'immagine apparirà questo

            //ora faccio php artisan storage:link e le immagini che salvo in storage vanno anche nello storage di public
        }

        //crea un post riempiendo i campi del form uno per uno (gli vanno detti):
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->save();
        

        // crea un post riempiendo i campi del form tutti insieme: 
        $data = $request->all(); //prende tutte le richieste contenute nel form...
        $post->fill($data);  //riempie tutti i campi...
        $post->save();

        //return redirect('/home')->with('success', 'Post creato correttamente');
        return redirect('posts/' . $post->id)->with('success', 'Post creato correttamente');
        
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
            'cover_image' => 'image|nullable|max:1999'
        ]);

        
        //crea un post riempiendo i campi del form uno per uno (gli vanno detti):
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        /*************** CANCELLARE L'IMMAGINE CORRENTE CON CHECKBOX, A COMANDO DELL'UTENTE ******************/

        // TRICK: Uso una check-box (a mo' di variabile sentinella) per cancellare l'immagine corrente del post: se la checkbox ha valore 'cancella' (e ce l'ha), parte la fuzione storage::delete...  In pratica uso la check box quasi come un bottone che al click si segna di cancellare la foto appena Salvo il post con le modifiche:
        if ($request->input ('delete-image') == 'checked') {
            Storage::delete('public/cover_images/'. $post->cover_image);  //immagine sull'HDD
            $post->cover_image = null;  //annullo l'immagine anche sul db, sennò funziona ma dà errore in console
        }


        /***** CANCELLA IMMAGINE PRESENTE QUANDO SE NE UPPA UNA NUOVA: quasi uguale a quella in store ma con Storage::delete *****/
        if ($request->hasFile('cover_image')) {
            
           Storage::delete('public/cover_images/'. $post->cover_image);  //concatenazione per avere il path completo dell'immagine
            
            // ottenere il nome del file con estensione
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //ottenere solo il nome del file
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);   //pathinfo() estrae il nome senza estenzione, è PHP puro
            //ottenere solo l'estensione
            $extension = $request->file('cover_image')->getClientOriginalExtension(); 
            //Nome del file da salvare
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Upload dell'immagine
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);  //crea una cartella in storage/app/public che si chiama 'public images' e ci salva l'immagine col nome appena costruito.
            $post->cover_image = $fileNameToStore;
        }

        // crea un post riempiendo i campi del form tutti insieme: 
        $data = $request->all(); //prende tutte le richieste contenute nel form...
        $post->fill($data);  //riempie tutti i campi...
        $post->save();

        
        //return redirect('/home')->with('success', 'Post modificato correttamente');
        return redirect('posts/'. $post->id)->with('success', 'Post modificato correttamente'); //NOTA: l'avviso di successo della modifica del post non si vede.
                     
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
        /* versione 1) 
        dove il backend restituisce TUTTO il contenuto del DB, cioé TUTTI i post senza filtri. Può andare bene per progetti piccoli... ma sarebbe meglio non inviare tutti i dati del db in una sola richiesta:

        $posts = Post::orderBy('created_at', 'desc')->get();

        /* per trasformare una collection in un array serve creare un array vuoto dove pushare i singoli post presi dalla collection:
        
        $arrayPosts= [];
        foreach ($posts as $post) {
            $arrayPosts[] = $post->toArray();
        } 
        dd($arrayPosts);
        
       ... oppure  ->toArray()

        $posts = Post::orderBy('created_at', 'desc')->get()->toArray(); 

        */
        


        /* versione 2) 
        dove creo i vari parametri per costruire il link del pacchetto JSON con un minimo di filtro iniziale. Non dovrei inviare da subito $posts::all(), altrimenti all'utente arrivano chissà quante centinaia di risultati e chissà in quanti minuti gli si caricano.

        $termine = $_GET['termine'];  //oppure    $termine = Input::get('termine');
        $maxResults = $_GET['maxResults']; // oppure    $maxResults = Input::get('maxResults');

        $posts = Post::where('title', 'LIKE', '%'.$termine.'%')->limit($maxResults)->get();

        $posts = Post::orderBy('created_at', 'desc')->get()->toArray();

        $postsPerJs = json_encode($posts);
        return $postsPerJs;

        */
        
    }
}
