<?php

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DifferentRuleValidator extends Illuminate\Validation\Validator
{
    public function validateDifferentIfExists($attribute, $value, $params, $validator) {
		$this->requireParameterCount(1, $params, 'different_if_exists');

		if(array_key_exists($params[0], $this->getData())) {
			$otherField = $this->getData()[$params[0]];

			return $value !== $otherField;
		}

		return true;
    }

	protected function replaceDifferentIfExists($message, $attribute, $rule, $parameters) {
	    return str_replace(':other', $this->getAttribute($parameters[0]), $message);
	}
}

Validator::resolver(function($translator, $data, $rules, $messages) {
    return new DifferentRuleValidator($translator, $data, $rules, $messages);
});

/*
|--------------------------------------------------------------------------
| Model Binders
|--------------------------------------------------------------------------
| Implement your model bindings in here. There is no default "spot" in
| Laravel to put these, so I made one over here. :-)
|
*/

/**
 * Voorbeeld
 *
 * In je route (routes.php) kun je aan route model binding doen.
 * Wat dit inhoudt, is dat je bijvoorbeeld de gebruiker automatisch
 * kan laten opzoeken met de naam "Jan" bij het surfen naar
 * www.site.be/user/jan
 *
 * De "action" waar deze route naar leidt, krijgt dan als parameter
 * User $user
 * In $user wordt automatisch de gebruiker met voornaam "Jan" geïnjecteerd.
 *
 * Er zijn ook standaard model binders die je niet moet implementeren.
 * Die werken sowieso met de id's. Dus bijvoorbeeld
 * www.site.be/user/5
 * De gebruiker met id 5 wordt dan geïnjecteerd.
 * Dit doe je als volgt:
 * 
 * Route::model('user', 'User');
 *
 * Je kan ook een closure als 3de parameter toevoegen die moet uitgevoerd worden
 * als de bijhorende model niet is gevonden:
 * 
 * Route::model('user', 'User', function() {
 *     throw new NotFoundHttpException;
 * });
 *
 * Als je nu per sé zoals eerst aangehaald, de gebruikers met de voornaam
 * wilt opzoeken, moet je een custom model binder maken.
 * Dit doe ik in het voorbeeld hieronder.
 * Wel niet vergeten de route aan te passen!
 * Route::get('/user/{user}', ...); <--- {user} stelt dan je model voor
 *
 * Makkelijk niet? Zoveel hokus pokus! Wauw!
 * 
 */

// Haal uit commentaar voor mooiere mark-up...
/* Route::bind('user', function($value, $route) { // user is wat er tussen {} staat!
	// value bevat hier in dit voorbeeld de voornaam
	$user = User::where('firstname', '=', $value)->first();
	if(is_null($user)) {
		// Als de gebruiker met value (bv Jan) als firstname niet gevonden is, throw je een exception
		throw new NotFoundHttpException;
	}

	// Wel gevonden? Return de gebruiker die geïnjecteerd moet worden in je functie!
	return $user;
}); */

/**
 * Deze binder zoekt de gebruiker op basis van de
 * meegeleverde id, e-mail of username.
 *
 * We checken eerst of het numeriek is, dan zoeken we
 * op id.
 * Dan checken we op een amil, zoeken we op e-mail.
 * Als laatste proberen we nog op username.
 *
 * Dit is tijdelijk en kan nog veranderen, aangezien
 * we niet weten welke van de drie het meest gebruikt
 * gaat worden en of we ze wel allemaal gaan
 * ondersteunen.
 */
Route::bind('user', function($value, $route) {
	$userRepository = App::make('UserRepository');

	if(is_numeric($value)) {
		$user = $userRepository->getById($value);

		if(is_null($user))
			throw new BadRequestHttpException;
		
		return $user;
	}
	
	if(filter_var($value, FILTER_VALIDATE_EMAIL)) {
		$user = $userRepository->getByEmail($value);

		if(is_null($user))
			throw new BadRequestHttpException;
		
		return $user;
	}

	throw new BadRequestHttpException;

	/*$user = $userRepository->getByUsername($value);

	if(is_null($user))
		throw new BadRequestHttpException;
	
	return $user;*/
});