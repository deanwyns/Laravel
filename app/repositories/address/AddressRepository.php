<?php

interface AddressRepository {

	public function getById($id, array $with = []);	
	public function update ($address, $attributes);
}