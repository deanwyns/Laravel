<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('App\Repositories\User\UserRepository', function($app) {
			return new UserRepositoryImpl( new User );
		});
	}

}