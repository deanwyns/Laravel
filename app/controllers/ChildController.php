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

	public function __construct(ChildRepository $childRepository){
		$this->childRepository = $childRepository;
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
		$attributes = Input::all();
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

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
