<?php

interface AddressRepository {

	public function getById($id, array $with = []);	
}