<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;

class RegistrationController extends \APIBaseController {
	use ControllerTrait;

	protected $registrationRepository;

	public function __construct(RegistrationRepository $registrationRepository){
		$this->registrationRepository = $registrationRepository;
	}

	public function show($registration){
		return $registration;
	}

		public function store($child)
	{
		$registration = new Registration;
		$attributes = Input::all();
		$attributes['child_id'] = $child->id;
		if(!$registration->validate($attributes))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de inschrijving', $registration->errors());

				if($this->registrationRepository->create($attributes))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de inschrijving');	
	}

	public function update($registration)
	{
		if(!$registration->validate(Input::all(), true, $registration->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van de inschrijving', $registration->errors());

		if($registration->update(Input::all()))
			return $registration;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van de inschrijving');

		return $registration;
	}

	public function destroy($registration)
	{
		if($registration->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);
			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen van de inschrijving');
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
