<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;


class VacationController extends \APIBaseController {

	use ControllerTrait;

	protected $vacationRepository;

	public function __construct(VacationRepository $vacationRepository){
		$this->vacationRepository = $vacationRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->vacationRepository->all();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$vacation = new Vacation;
		if(!$vacation->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de vakantie', $vacation->errors());

		//if($vacation->save())
		if($this->vacationRepository->create(Input::all()))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de vakantie');	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($vacation)
	{
		return $vacation;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($vacation)
	{
		if(!$vacation->validate(Input::all(), true, $vacation->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van de vakantie', $vacation->errors());

		if($vacation->update(Input::all()))
			return $vacation;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van de vakantie');

		return $vacation;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($vacation)
	{
		if($vacation->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);
			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen van een vakantie');
	}

	public function getVacationAlbum($vacation) {
		if(empty($vacation->picasa_album_id)) {
			return [];
		}

		Laracasa::setAlbum($vacation->picasa_album_id);
		$result = Laracasa::getAlbum();
		
		return $result;
	}

	public function getAlbums() {
		return Laracasa::getAlbums();
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}

	public function showRegistrations($vacation){
		return $vacation->registrations();
	}

}
