<?php

class SocialNetworkRepositoryImpl extends AbstractRepository implements SocialNetworkRepository {

	public function __construct(SocialNetwork $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []){
		$query = $this->make($with);
		
		return $query->where('id', '=', $id)->first();
	}
}