<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;


class SocialNetworkController extends \APIBaseController {

	use ControllerTrait;

	protected $socialNetworkRepository;

	public function __construct(SocialNetworkRepository $socialNetworkRepository){
		$this->socialNetworkRepository = $socialNetworkRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->socialNetworkRepository->all();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$attributes = Input::all();
		$attributes['monitor_id'] = $this->auth->user()->userable->id;
		$socialNetwork= new SocialNetwork;
		if(!$socialNetwork->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het sociaal netwerk', $socialNetwork->errors());

		
		if($this->socialNetworkRepository->create(Input::all()))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het sociaal netwerk');	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($socialNetwork)
	{
		return $socialNetwork;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($socialNetwork)
	{
		if(!$socialNetwork->validate(Input::all(), true, $socialNetwork->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het sociaal netwerk', $socialNetwork->errors());

		if($socialNetwork->update(Input::all()))
			return $socialNetwork;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het sociaal netwerk');

		return $socialNetwork;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($socialNetwork)
	{
		if($socialNetwork->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);
			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen van het sociaal netwerk');
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
