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

	//kijkt of het kind is verbonden met de ingelogde gebruiker of dat de ingelogde gebruiker een admin is
	private function checkForDabbling($child){
		//aanmaken booleans om de leesbaarheid te vergroten
		$currentUser = $this->auth->user();
		$isChildFrom = ($currentUser->userable->id == $child->parents_id) && $currentUser->userable_type == 'Parents';
		$isAdmin = $currentUser->userable_type == "Admin";

		//check of alle voorwaarden zijn voldaan
		if($isChildFrom || $isAdmin)
			return true;
		else
			return false;
	}

	public function show($registration){
		//kind waar de inschrijving op van toepassing is ophalen a.d.h.v. id
		$child = $this->childRepository->getById($registration['child_id']);

		//mag de ingelogde gebruiker het kind zijn gegevens zien?
		if(!$this->checkForDabbling($child))
			throw new UnauthorizedHttpException("U kunt enkel de inschrijvingen van uw eigen kinderen bekijken");
		else
			return $registration;
	}

		public function store($child)
	{
		$registration = new Registration;

		//mag de ingelogde gebruiker het kind zijn gegevens zien?
		if(!$this->checkForDabbling($child))
			throw new UnauthorizedHttpException("U kunt enkel uw eigen kinderen inschrijven");

		//child_id uit de URL halen en invoegen in de invoerParameters.
		$attributes = Input::all();
		$attributes['child_id'] = $child->id;

		//checken of de vakantie bestaat
		$vacationId = $attributes['vacation_id'];
		$vacation = $this->vacationRepository->getById($vacationId);
		if($vacation == null){
			throw new StoreResourceFailedException(
				'De gekozen vakantie bestaat niet!');
		}

		//valideren van de regels gespecifieerd in het model
		if(!$registration->validate($attributes))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de inschrijving', $registration->errors());

				if($this->registrationRepository->create($attributes))
				{
					if($this->increaseParticipants($vacation))
					return $this->created(); // HTTP Status Code 201 "Created"
					else 
						throw new StoreResourceFailedException('Deze vakantie is volgeboekt.');
				}

				else
				{
					throw new StoreResourceFailedException(
						'Fout bij het aanmaken van de inschrijving');	
				}

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

	public function increaseParticipants($vacation){
		if($vacation->current_participants < $vacation->max_participants){
			$vacation->current_particpants+1;
			return true;
		}
		else {
			return false;
		}
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
