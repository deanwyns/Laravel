<?php
class RegistrationController extends \APIBaseController {
	use ControllerTrait;

	protected $registrationRepository;

	public function __construct(RegistrationRepository $registrationRepository){
		$this->registrationRepository = $registrationRepository;
	}

	public function show($registration){
		return $registration;
	}

		public function store()
	{
		$registration = new Registration;
		if(!$registration->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het kind', $registration->errors());

				if($this->registrationRepository->create(Input::all()))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het kind');	
	}

	public function update($registration)
	{
		if(!$registration->validate(Input::all(), true, $registration->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het kind', $registration->errors());

		if($registration->update(Input::all()))
			return $vacation;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het kind');

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
				'Fout bij het verwijderen van het kind');
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
