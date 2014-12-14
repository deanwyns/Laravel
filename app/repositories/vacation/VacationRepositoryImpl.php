<?php
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class VacationRepositoryImpl extends AbstractRepository implements VacationRepository {

	public function __construct(Vacation $model) {
		$this->model = $model;
	}

	public function getByTitle($title, array $with = []) {
		$query = $this->make($with);

		return $query->where('title', '=', $title)->first();
	}

	public function getById($id, array $with = []){
		$query = $this->make($with);
		
		return $query->where('id', '=', $id)->first();
	}

	public function getRegistrations($vacation){
		return $vacation->registrations;
	}

	//geeft alle verschillende categorieën terug
	public function getCategories() {
		return Category::all();
	}

	//maakt een categorie aan
	public function createCategory($attributes) {
		return Category::create($attributes);
	}

	//geeft het aantal Likes dat er zijn gekoppeld aan de gegeven vakantie terug
	public function getLikes($vacation){
		return sizof($vacation->likes);
	}

	//voegt een like toe aan de gegeven vakantie
	public function createLike($attributes){
		$vacation = $this->getById($attributes['vacation_id']);
		$likes = $vacation->likes;

		//controleert of de vakantie nog niet is leuk gevonden door de user
		foreach($likes as $key => $value){
			if($value->user_id == $attributes['user_id']){
				throw new UnauthorizedHttpException('Je kan een vakantie maar één keer leuk vinden');
			}
		}

		//als het de eerste keer is dat de gebruiker deze vakantie wil leuk vinden wordt de Like aangemaakt.
		return Like::create($attributes);
	}
}