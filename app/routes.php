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

// Voor API authentication maken we gebruik van OAuth2:
// een open standaard voor autorisatie...
// Ik heb in de config van dingo/api (in app/config/packages/dingo/api/config.php)
// OAuth ingesteld als autorisatie (ipv basic waarbij je username &
// password ELKE request meestuurt en controleert).
// 
// Als grant type gebruiken we "password", dat het meest gangbare is
// voor mobile app <---> REST API
// 
// Voor OAuth is het verplicht per client (per app) een client id
// en client secret te maken. Secret is eigenlijk alleen nodig
// als je app niet publiek is, maar kan geen kwaad om toch in
// te stellen.
// 
// We zouden in de database dus twee clients moeten registreren:
// één voor Android en één voor de AngularJS app
// 
// Om toegang te krijgen tot onze REST API moeten ze eerst
// een access token aanvragen, en dat gebeurt met onderstaande route.
// 
// Bij dez request geef je de client id, client secret (die de app dus weet),
// username en password mee.
// 
// Doe je met een POST request (ik gebruik cURL):
// curl -X POST "http://site.be/oauth/access_token" 
// -d "grant_type=password&client_id=CLIENTIDHIER
// 						  &client_secret=CLIENTSECRETHIER
// 						  &username=USERNAME
// 						  &password=PASSWORD"
// 						  
// Via Android & Angular zal dit uiteraard anders gaan, maar
// dit is ook maar voor te testen of het werkt.
// 
// De reponse op bovenstaande opdracht is in JSON:
// {"access_token":"x38iMoKC08lpPNM7Ovgw2SP0wjlLyUiMLDHmx2R4","token_type":"Bearer","expires_in":3600}
// Je krijgt een token van type Bearer (je hebt er een paar, maar Bearer is standaard)
// die vervalt binnen één uur (wat lang genoeg is, want denk niet dat iemand zo
// lang met de app bezig gaat zijn..., als 't vervalt vullen ze simpelweg
// nog eens hun gegevens in).
// 
// Met deze token krijg je dan toegang tot de "protected" endpoints
// (zo noemen de URL's die je aanroept om gegevens op te vragen).
// 
// Doe je evenals met een POST request:
// curl -H "Authorization: Bearer x38iMoKC08lpPNM7Ovgw2SP0wjlLyUiMLDHmx2R4" -X POST "http://site.be/api/user"
// 
// Aangezien de UserController nog niets teruggeeft, is de response leeg. Als je die
// token niet meegeeft, of de foute, krijg je respectievelijk:
// {"error":"access_denied","error_description":"The resource owner or authorization server denied the request."}
// {"message":"Failed to authenticate because of bad credentials or an invalid authorization header.","status_code":401}
// 
// Zo, dat is weer een lange uitleg! :D
// Hopelijk is dit nu wat duidelijker... Ik weet dat het wat nieuw en onduidelijk is (voor mij ook),
// maar zo wordt dit door alle goede apps gedaan die gebruik maken van een REST API.
// Zou hetzelfde werken in .NET en Java.
// 						 
Route::post('api/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

// Route::api komt van de package dingo/api
// Die zorgt voor de access, versioning enzo...
// 
// In de config file van dingo/api heb ik de default prefix
// op 'api' gezet, zodat je dit niet bij elke group hier
// moeten zetten.
Route::api(['version' => 'v1'], function() {
	// Hier komen alle routes specifiek voor onze RESTful API.
	// Prefix wilt zeggen dat voor elke request /api/ komt.
	// Before is een lijst van filters die voor de request naar
	// de controller wordt verstuurd, worden uitgevoerd.
	// 
	// Resource omvat een heleboel routes in één statement.
	// Alle CRUD operaties eigenlijk, maar er zitten
	// ook methoden bij om een create of edit form aan
	// te vragen, en die moeten weg, want we werken met puur
	// een API :-)
	Route::group(['prefix' => 'user'], function() {
		Route::get('me', ['uses' => 'UserController@getMe', 'protected' => true, 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::get('/', ['uses' => 'UserController@index', 'protected' => true, 'scopes' => 'admin']);
		// Dit is de route voor een parents account
		// Iedereen kan dit aanmaken
		Route::post('/', 'UserController@store');
		// Dit is de route voor een monitor account
		// Enkel admins kunnen dit aanmaken
		Route::post('/monitor', ['uses' => 'UserController@storeMonitor', 'protected' => true, 'scopes' => 'admin']);
		// Dit is de route voor een admin account
		// Enkel admins kunnen dit aanmaken
		Route::post('/admin', ['uses' => 'UserController@storeAdmin', 'protected' => true, 'scopes' => 'admin']);
		Route::get('/{user}', ['uses' => 'UserController@show', 'protected' => true, 'scopes' => 'admin']);
		Route::put('/{user}', ['uses' => 'UserController@update', 'protected' => true, 'scopes' => 'admin']);
		Route::delete('/{user}', ['uses' => 'UserController@destroy', 'protected' => true, 'scopes' => 'admin']);
		//geef alle kinderen terug die horen bij een gebruiker.
		Route::get('/me/children',['uses'=> 'UserController@getChildren', 'scopes' => ['parents', 'monitor', 'admin']]);
		//CRUD voor kindenen -> een gebruiker kan enkel deze functies gebruiken voor zijn eigen kinderen dus /me
		Route::post('/me/children', ['uses' => 'ChildController@store', 'protected' => true, 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::get('/me/{child}', ['uses' => 'ChildController@show', 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::put('/me/{child}', ['uses' => 'ChildController@update', 'protected' => true, 'scopes' => ['parents', 'admin']]);
		Route::delete('/me/{child}', ['uses' => 'ChildController@destroy', 'protected' => true, 'scopes' => ['parents', 'monitor', 'admin']]);

		Route::get('/me/{child}/registrations', ['uses' => 'ChildController@showRegistrations', 'scopes' => ['parents', 'admin']] );

		//CRUD voor inschrijvingen
		Route::post('/me/{child}/register', ['uses' => 'RegistrationController@store', 'protected' => true, 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::get('/me/{registration}', ['uses' => 'RegistrationController@show', 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::put('/me/{registration}', ['uses' => 'RegistrationController@update', 'protected' => true, 'scopes' => 'admin']);
		Route::delete('/me/{registration}', ['uses' => 'RegistrationController@destroy', 'protected' => true, 'scopes' => 'admin']);

	});
	
	Route::group(['prefix' => 'child'], function(){
		Route::get('/{child}',['uses'=> 'ChildController@show', 'scopes' => 'admin']);
	});

	Route::group(['prefix' => 'vacation'], function() {
		Route::get('/', ['uses' => 'VacationController@index', 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::post('/', ['uses' => 'VacationController@store', 'protected' => true, 'scopes' => 'admin']);
		Route::get('/{vacation}', ['uses' => 'VacationController@show', 'scopes' => ['parents', 'monitor', 'admin']]);
		Route::put('/{vacation}', ['uses' => 'VacationController@update', 'protected' => true, 'scopes' => 'admin']);
		Route::delete('/{vacation}', ['uses' => 'VacationController@destroy', 'protected' => true, 'scopes' => 'admin']);
		Route::get('/{vacation}/registrations',['uses' => 'VacationController@showRegistrations', 'protected' => true, 'scopes' => 'admin']);
	});

	/*Route::group(['prefix' => 'user']), function() {
		Route::post('{user}', )
	});*/
	// Dit wordt dus respectievelijk
	// www.joetz.be/api/user/
	// www.joetz.be/api/vakantie/
});

// Voorlopig even met id's werken tot we wat meer hebben...
Route::model('child', 'Child');
Route::model('vacation', 'Vacation');
Route::model('registration', 'Registration');