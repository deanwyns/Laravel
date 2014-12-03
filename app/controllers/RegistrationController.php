<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RegistrationController extends \APIBaseController {
	use ControllerTrait;

	protected $registrationRepository;
	protected $vacationRepository;
	protected $childRepository;

	public function __construct(RegistrationRepository $registrationRepository, VacationRepository $vacationRepository, ChildRepository $childRepository){
		$this->registrationRepository = $registrationRepository;
		$this->vacationRepository = $vacationRepository;
		$this->childRepository = $childRepository;
	}

	public function show($registration){
		//kind waar de inschrijving op van toepassing is ophalen a.d.h.v. id
		$child = $this->childRepository->getById($registration['child_id']);

		//aanmaken booleans om de leesbaarheid te vergroten
		$currentUser = $this->auth->user();
		$isChildFrom = ($currentUser->userable->id == $child->parents_id) && $currentUser->userable_type == 'Parents';
		$isAdmin = $currentUser->userable_type == "Admin";

		//check of alle voorwaarden zijn voldaan
		if($isChildFrom || $isAdmin)
			return $registration;
		else
			throw new UnauthorizedHttpException("U kunt enkel de gegevens van de inschrijvingen van uw eigen kinderen bekijken");
	}

		public function store($child)
	{
		$registration = new Registration;

		//child_id uit de URL halen en invoegen in de invoerParameters.
		$attributes = Input::all();
		$attributes['child_id'] = $child->id;

		//checken of de vakantie bestaat
		$vacationId = $attributes['vacation_id'];
		if($this->vacationRepository->getById($vacationId)== null){
			throw new StoreResourceFailedException(
				'De gekozen vakantie bestaat niet!');
		}

		//valideren van de regels gespecifieerd in het model
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
