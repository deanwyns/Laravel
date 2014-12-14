<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;


class AddressController extends \APIBaseController {

	use ControllerTrait;

	protected $addressRepository;

	public function __construct(AddressRepository $addressRepository){
		$this->addressRepository = $addressRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->addressRepository->all();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$address = new Address;
		if(!$address->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het adres', $address->errors());

		//if($address->save())
		if($address = $this->addressRepository->create(Input::all()))
			return $address; // geef het adres terug zodat het id eventueel kan hergebruikt worden
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van het adres');	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($address)
	{
		return $address;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($address)
	{
		$attributes = Input::all();
		return $this->addressRepository->update($address, $attributes);

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($address)
	{
		if($address->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);
			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen van het adres');
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}
}
