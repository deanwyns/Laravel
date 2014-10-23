<?php

use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;

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
		if(!$user->validatePassedOnly(Input::all()))
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
		if($user->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);

			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen gebruiker');
	}


}