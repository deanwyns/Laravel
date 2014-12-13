<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
	protected $addressRepository;
	/**
	 * Constructor
	 */
	public function __construct(UserRepository $userRepository, AddressRepository $addressRepository) {
		$this->userRepository = $userRepository;
		$this->addressRepository = $addressRepository;
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
		$attributes = Input::all();
		$user = new User; $parents = new Parents; $address = new Address;
		/*if(!in_array('address_id', $attributes)) {
			if(!$address->validate($attributes)) {
				throw new StoreResourceFailedException(
					'Fout bij het aanmaken gebruiker');
			}

			$address = $this->addressRepository->create($attributes);
			if(!$address) {
				throw new StoreResourceFailedException(
					'Fout bij het aanmaken gebruiker');
			}
		}

		$attributes['address_id'] = $address->id;*/

		if(!($user->validate($attributes) & $parents->validate($attributes))) {
			$userError = is_object($user->errors()) ? $user->errors()->toArray() : [];
			$subUserError = is_object($parents->errors()) ? $parents->errors()->toArray() : [];
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken gebruiker',
				['messages' => array_merge($userError, $subUserError)]);
		}
		if($this->userRepository->createParents($attributes)) {
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

	public function updateMe() {
		$user = $this->auth->user();
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
		} else{
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen gebruiker');
		}
	}
	
	//Voor Parents
	public function getChildren()
	{
		return $this->userRepository->getChildren($this->auth->user());
	}


	public function getAddress()
	{
		$address_mother = $this->addressRepository->getById($this->userRepository->getMotherAddress($this->auth->user()));
		$address_father = $this->addressRepository->getById($this->userRepository->getFatherAddress($this->auth->user()));

		$address_info['address_mother'] = $address_mother;
		$address_info['address_father'] = $address_father;
 		return $address_info;
	}

	//Voor Monitors
	public function showMonitor($monitor){
		return $monitor;
	}

	//zoeken in monitors
	public function searchMonitor(){
		//alle attributen ophalen
		$attributes = Input::All();

		//zoekstring opsplitsen
		$searchString = $attributes['search_string'];
		$searchArray = explode(' ', $searchString,2);
		$monitors = [];

		//searchArray>1 betekent dat er wordt gezocht op een volledige naam (voor + familienaam)
		if(sizeof($searchArray)>1){			
			//Voornaam Familienaam
			$monitorsHelper = DB::table('users_monitors')->Where('first_name', $searchArray[0])->Where('last_name', $searchArray[1])->get();
			//$monitors wordt vervangen ipv gepushed omdat 
			$monitors = $monitorsHelper;

			//Familienaam Voornaam de "empty($searchArray)" voorkomt dat er een extra lege array wordt meegegeven
			if(empty($monitors)){
				$monitorsHelper = DB::table('users_monitors')->Where('first_name', $searchArray[1])->Where('last_name', $searchArray[0])->get();
				array_push($monitors, $monitorsHelper);
			}
		}
		else{
			$monitors = DB::table('users_monitors')->Where('first_name', $searchArray[0])->orWhere('last_name', $searchArray[0])->get();
		}
        return $monitors;
    }

	//voor alle Users
	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}

	
