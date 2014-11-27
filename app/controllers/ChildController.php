<?php
class ChildController extends \APIBaseController {
	use ControllerTrait;

	protected $childRepository;

	public function __construct(ChildRepository $childRepository){
		$this->childRepository = $childRepository;
	}

	public function show($child){
		return $child
	}

		public function store()
	{
		$child = new Child;
		if(!$child->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het kind', $child->errors());

				if($this->childRepository->create(Input::all()))
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
			return $vacation;
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
		return $child->registrations();
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
