<?php

interface SocialNetworkRepository {
	public function getById($id, array $with = []);
}