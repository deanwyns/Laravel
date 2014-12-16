<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RegistrationController extends \APIBaseController {
	use ControllerTrait;

	protected $registrationRepository;
	protected $vacationRepository;
	protected $childRepository;
	protected $addressRepository;

	public function __construct(RegistrationRepository $registrationRepository, VacationRepository $vacationRepository, ChildRepository $childRepository, AddressRepository $addressRepository){
		$this->registrationRepository = $registrationRepository;
		$this->vacationRepository = $vacationRepository;
		$this->childRepository = $childRepository;
		$this->addressRepository= $addressRepository;
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

	public function getAllRegistrations() {
		return $this->registrationRepository->all();
	}

	public function show($registration) {
		//kind waar de inschrijving op van toepassing is ophalen a.d.h.v. id
		$child = $this->childRepository->getById($registration['child_id']);

		//mag de ingelogde gebruiker het kind zijn gegevens zien?
		if(!$this->checkForDabbling($child))
			throw new BadRequestHttpException("U kunt enkel de inschrijvingen van uw eigen kinderen bekijken");
		else
			return $registration;
	}

	public function store($child)
	{
		$registration = new Registration;

		//mag de ingelogde gebruiker het kind zijn gegevens zien?
		if(!$this->checkForDabbling($child))
			throw new BadRequestHttpException('U kunt enkel uw eigen kinderen inschrijven');

		
		$attributes = Input::all();
		$vacationId = $attributes['vacation_id'];

		//checken of de vakantie bestaat		
		$vacation = $this->vacationRepository->getById($vacationId);
		if($vacation == null){
			throw new StoreResourceFailedException(
				'De gekozen vakantie bestaat niet!');
		}

		$birthday = new DateTime($child->date_of_birth);
		$today = new DateTime('today');
		$age = $birthday->diff($today)->y;

		if($age < $vacation->age_from){
			throw new BadRequestHttpException('Het kind dat u wenst in te schrijven is te jong');
		}

		if($age > $vacation->age_to){
			throw new BadRequestHttpException('Het kind dat u wenst in te schrijven is te oud om deel te nemen aan deze vakantie');
		}

		//child_id uit de URL halen en invoegen in de invoerParameters.
		$attributes['child_id'] = $child->id;
		//als er nog address werdt meegegeven?
		if(!in_array('address_id', $attributes)) {
			$address = new Address;

			//kijk of de gepaste variabelen om een address aan te maken werden meegegeven
			if(!$address->validate($attributes)) {
				throw new StoreResourceFailedException(
					'Fout bij het toevoegen van het adres');
			}
			//als de variabelen werden meegegeven en correct valideren wordt er een address aangemaakt
			$address = $this->addressRepository->create($attributes);
			if(!$address) {
				throw new StoreResourceFailedException(
					'Fout bij het toevoegen van het adres');
			}

			//voeg het address_id toe aan de attributen om de inschrijving te voltooien
			$attributes['facturation_address_id'] = $address->id;
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
		if(Input::has('is_paid')){
			$registration->is_paid = Input::get('is_paid');

		}
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
		return $vacation->current_participants < $vacation->max_participants;
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
