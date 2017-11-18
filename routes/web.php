<?php

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

Route::get('/', ['as'=>'admin.index','uses'=>'adminController@index']);

//ACCES AU FORMULAIRES
Route::get('/form/artist/{id?}', ['as'=>'form.artist','uses'=>'adminController@artistForm']);
Route::get('/form/place/{id?}', ['as'=>'form.place','uses'=>'adminController@placeForm']);


Route::get('/delartist/{id?}', ['as'=>'artist.delete','uses'=>'adminController@deleteArtist']);
Route::get('/delplace/{id?}', ['as'=>'artist.delete','uses'=>'adminController@deletePlace']);


//AJOUT ET MISE A JOUR
Route::post('/addartist', ['as'=>'artist.add','before' => 'csrf','uses'=>'adminController@addArtist']);
Route::post('/addplace', ['as'=>'place.add','before' => 'csrf','uses'=>'adminController@addPlace']);

Route::post('/updateartist', ['as'=>'artist.update','before' => 'csrf','uses'=>'adminController@updateArtist']);
Route::post('/updateplace', ['as'=>'place.update','before' => 'csrf','uses'=>'adminController@updatePlace']);
