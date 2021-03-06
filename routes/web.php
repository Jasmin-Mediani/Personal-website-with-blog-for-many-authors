<?php

use Illuminate\Support\Facades\Route;



Route::get('/welcome', function () {
    return view('welcome');
});
//NOTA: è importante dare un nome alle varie rotte con     ->name('')      per poterle linkare nelle view dentro gli <a></a>
Route::get('/', 'PagesController@index')->name('index');  
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/services', 'PagesController@services')->name('services');


/* Route::get('/about', function() {
    return view('pages.about');  //la view about che si trova in pages

}); */


Route::resource('posts', 'PostsController');  //nota: 'posts' è il nome della tabella che laravel genera automaticamente quando creo una classe di nome Post (il model Post, in pratica). 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');








// rotta di prova per una chiamata Ajax che renderizza tutti i post (è superflua perché lo faccio già lato backend qui con laravel)
Route::get('/api/posts', 'PostsController@apiPosts');