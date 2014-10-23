<?php

use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;

class UserController extends \APIBaseController {

	// Dit zorgt ervoor dat je voorgedefinieerde
	// variabelen van de dingo/api package kunt
	// gebruiken.
	// Bijvoorbeeld $auth waarmee je de user kunt opvragen:
	// $this->auth->user();
	use ControllerTrait;

	/**
	 * User Repository
	 * @var UserRepositoryImpl
	 */
	protected $userRepository;

	/**
	 * Constructor
	 */
	public function __construct(UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->userRepository->all();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new User;
		if(!$user->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken gebruiker', $user->errors());

		$user->email = Input::get('email');

		//Rounds stelt de "cost" voor (BCrypt)
		$user->password = Hash::make(Input::get('password'), ['rounds' => 12]);
		if($user->save())
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken gebruiker');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($user)
	{
		return $user;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($user)
	{
		// Anonieme fnctie die je meegeeft aan de validate functie van het Model.
		// Deze functie wordt uitgevoerd voor dat er gevalideerd wordt.
		// 
		// Moet zo gedaan worden om password_confirmed enkel required te maken
		// wanneer password is ingevuld. Lukt niet door de 'rules' aan te passen.
		$sometimes = function($validator) {
			$validator->sometimes('password_confirmed', 'required', function($input) use($validator) {
				return array_key_exists('password', $validator->getData());
			});
		};

		if(!$user->validate(Input::all(), $sometimes))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten gebruiker', $user->errors());

		if($user->update(Input::all()))
			return $user;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten gebruiker');

		return $user;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($user)
	{
		if($user->delete())
			return $this->setStatusCode(200); // HTTP Status Code 200 "OK"
		else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen gebruiker');
	}


}
