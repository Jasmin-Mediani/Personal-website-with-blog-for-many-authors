<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $user_id = auth()->user()->id;
        $posts = Post::where('user_id' , $user_id)->orderBy('created_at', 'desc')->paginate(10); //è un filtro per far vedere/modificare/eliminare solo i propri post a chi è autenticato. 
        $user = User::findOrFail($user_id);
        return view('home')->with('posts', $posts);
    }
}
