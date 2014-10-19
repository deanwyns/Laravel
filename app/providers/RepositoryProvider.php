<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('\UserRepository', function() {
			return new \UserRepositoryImpl(new \User);
		});
	}

}