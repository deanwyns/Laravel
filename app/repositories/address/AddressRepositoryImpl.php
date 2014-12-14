<?php

class AddressRepositoryImpl extends AbstractRepository implements AddressRepository {

	public function __construct(Address $model) {
		$this->model = $model;
	}

	public function getById($id, array $with = []) {
		$query = $this->make($with);
		return $query->where('id', '=', $id)->first();
	}

	public function update($address, $attributes){
		if(!$address->validate($attributes, true, $address->id))
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het adres', $address->errors());

		if($address->update($attributes))
			return $address;
		else
			throw new UpdateResourceFailedException(
				'Fout bij het updaten van het adres');

		return $address;
	}
}