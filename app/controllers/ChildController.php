<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ChildController extends \APIBaseController {
	use ControllerTrait;

	protected $childRepository;
	protected $addressRepository;

	public function __construct(ChildRepository $childRepository, AddressRepository $addressRepository){
		$this->childRepository = $childRepository;
		$this->addressRepository = $addressRepository;
	}

	public function show($child){
		$currentUser = $this->auth->user();
		if((($currentUser->userable->id == $child->parents_id)&&($currentUser->userable_type == "Parents"))||($currentUser->userable_type == "Admin"))
			return $child;
		else
			throw new UnauthorizedHttpException("U kunt enkel de gegevens van uw eigen kinderen bekijken");
	}

	public function store()
	{
		$child = new Child;
		$address = new Address;
		$attributes = Input::all();

		if(!in_array('address_id', $attributes)) {
			if(!$address->validate($attributes)) {
				throw new StoreResourceFailedException(
					'Fout bij het aanmaken van het kind', $address->errors());
			}

			$address = $this->addressRepository->create($attributes);
			if(!$address) {
				throw new StoreResourceFailedException(
					'Fout bij het aanmaken van het kind');
			}
		}

		$attributes['address_id'] = $address->id;

		$attributes['parents_id'] = $this->auth->user()->userable->id;	 	
		if(!$child->validate($attributes))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het kind', $child->errors());
	 	
				if($this->childRepository->create($attributes))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het kind');	
	}

	public function update($child)
	{
		if(!$child->validate(Input::all(), true, $child->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het kind', $child->errors());

		if($child->update(Input::all()))
			return $child;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het kind');

		return $child;
	}

	public function destroy($child)
	{
		if($child->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);
			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen van het kind');
	}

	public function showRegistrations($child){
		return $this->childRepository->getRegistrations($child);
	}

	public function getAddress($child){
		return $this->addressRepository->getById($this->childRepository->getAddress($child));
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
