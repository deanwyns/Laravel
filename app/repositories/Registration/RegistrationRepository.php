<?php

interface RegistrationRepository {
	
	public function getById($id, array $with = []);
	
}