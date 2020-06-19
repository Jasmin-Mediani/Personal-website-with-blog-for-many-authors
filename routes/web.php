<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
