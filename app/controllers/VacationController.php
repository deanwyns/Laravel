<?php
use Dingo\Api\Routing\ControllerTrait;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\ResponseBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


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

	public function getCategories() {
		return $this->vacationRepository->getCategories();
	}

	public function getCategory($category) {
		return $category;
	}

	public function getCategoryPhoto($category) {
		$data = $category->photo_url;

		/*list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);*/

		$image = Image::make($data);
		return $image->response('jpg');
	}

	public function postCategory() {
		$category = new Category;
		if(!$category->validate(Input::all()))
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de vakantie', $category->errors());

		if($this->vacationRepository->createCategory(Input::all()))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het aanmaken van de vakantie');
	}

	public function updateCategory($category) {
		if(!$category->validate(Input::all(), true, $category->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van de categorie', $category->errors());

		if($category->update(Input::all()))
			return $category;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van de categorie');

		return $category;
	}

	public function deleteCategory($category) {
		if($category->delete()) {
			$response = new ResponseBuilder(null);
			// HTTP Status Code 200 "OK"
			$response->setStatusCode(200);
			return $response; 
		} else
			throw new DeleteResourceFailedException(
				'Fout bij het verwijderen van categorie');
	}

	public function missingMethod($parameters = []) {
	    return $this->errorNotFound();
	}

	public function showRegistrations($vacation){
		return $this->vacationRepository->getRegistrations($vacation);
	}

	public function like($vacation){
		if($this->auth->user()->userable_type != 'Parents'){
			throw new UnauthorizedHttpException('Enkel ouders mogen een vakantie leuk vinden');
		}

		$attributes = Input::all();
		$attributes['vacation_id'] = $vacation->id;
		$attributes['user_id'] = $this->auth->user()->id;

		$like = new Like;
		if(!$like->validate($attributes))
			throw new StoreResourceFailedException(
				'Fout bij het leuk vinden van de vakantie', $like->errors());

		if($this->vacationRepository->createLike($attributes))
			return $this->created(); // HTTP Status Code 201 "Created"
		else
			throw new StoreResourceFailedException(
				'Fout bij het leuk vinden van de vakantie');
	}

}
