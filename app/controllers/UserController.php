<?php

use Dingo\Api\Routing\ControllerTrait;

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
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($user)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($user)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($user)
	{
		//
	}


}
