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
		$user = new User; $parents = new Parents;
		if(!($user->validate(Input::all()) & $parents->validate(Input::all()))) {
			$userError = is_object($user->errors()) ? $user->errors()->toArray() : [];
			$subUserError = is_object($parents->errors()) ? $parents->errors()->toArray() : [];
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken gebruiker',
				['messages' => array_merge($userError, $subUserError)]);
		}
		if($this->userRepository->createParents(Input::all())) {
			return $this->created();
		} else {
			throw new StoreResourceFailedException(
					'Fout bij het aanmaken gebruiker');
		}
	}
	public function storeMonitor() {
		$user = new User; $monitor = new Monitor;
		if(!($user->validate(Input::all()) & $monitor->validate(Input::all()))) {
			$userError = is_object($user->errors()) ? $user->errors()->toArray() : [];
			$subUserError = is_object($monitor->errors()) ? $monitor->errors()->toArray() : [];
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken gebruiker',
				['messages' => array_merge($userError, $subUserError)]);
		}
		if($this->userRepository->createMonitor(Input::all())) {
			return $this->created();
		} else {
			throw new StoreResourceFailedException(
					'Fout bij het aanmaken gebruiker');
		}
	}
	public function storeAdmin() {
		$user = new User; $admin = new Admin;
		if(!($user->validate(Input::all()) & $admin->validate(Input::all()))) {
			$userError = is_object($user->errors()) ? $user->errors()->toArray() : [];
			$subUserError = is_object($admin->errors()) ? $admin->errors()->toArray() : [];
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken gebruiker',
				['messages' => array_merge($userError, $subUserError)]);
		}
		if($this->userRepository->createAdmin(Input::all())) {
			return $this->created();
		} else {
			throw new StoreResourceFailedException(
					'Fout bij het aanmaken gebruiker');
		}
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
	 * Display the authenticated user
	 * 
	 * @return Reponse
	 */
	public function getMe() {
		return $this->auth->user();
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($user)
	{
		$subtype = $user->userable;
		if(!($user->validate(Input::all(), true, $user->id) & $subtype->validate(Input::all(), true, $user->id))) {
			$userError = is_object($user->errors()) ? $user->errors()->toArray() : [];
			$subUserError = is_object($subtype->errors()) ? $subtype->errors()->toArray() : [];
			throw new UpdateResourceFailedException(
				'Fout bij aanpassen gebruiker',
				['messages' => array_merge($userError, $subUserError)]);
		}

		if($user->userable->update(Input::all()) & $user->update(Input::all())) {
			return $user;
		} else {
			throw new UpdateResourceFailedException(
					'Fout bij aanpassen gebruiker');
		}

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
	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}

	public function getChildren(){
		return $this->userRepository->getChildren($this->auth->user());
	}
}