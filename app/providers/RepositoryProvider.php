<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('\UserRepository', function() {
			return new \UserRepositoryImpl(new \User);
		});
		$this->app->bind('\VacationRepository', function() {
			return new \VacationRepositoryImpl(new \Vacation);
		});		
		$this->app->bind('\ChildRepository', function() {
			return new \ChildRepositoryImpl(new \Child);
		});		
		$this->app->bind('\RegistrationRepository', function() {
			return new \RegistrationRepositoryImpl(new \Registration, new \Vacation, new \Child);
		});		
		$this->app->bind('\AddressRepository', function() {
			return new \AddressRepositoryImpl(new \Address);
		});	
		$this->app->bind('\SocialNetworkRepository', function() {
			return new \SocialNetworkRepositoryImpl(new \SocialNetwork);
		});	
	}
}