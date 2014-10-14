<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'api', 'before' => 'auth.token'], function() {
	// Hier komen alle routes specifiek voor onze RESTful API.
	// Prefix wilt zeggen dat voor elke request /api/ komt.
	// Before is een lijst van filters die voor de request naar
	// de controller wordt verstuurd, worden uitgevoerd.
	Route::resource('user', 'UserController');
	Route::resource('vakantie', 'VakantieController');
	// Dit wordt dus respectievelijk
	// www.joetz.be/api/user/
	// www.joetz.be/api/vakantie/
});

// Voorlopig even met id's werken tot we wat meer hebben...
Route::model('user', 'User');
Route::model('vakantie', 'Vakantie');