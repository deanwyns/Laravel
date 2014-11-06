<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends ValidatableEloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Fillable attributes
	 * @var array
	 */
	protected $fillable = ['email', 'password', 'first_name_mother',
							'last_name_mother', 'nrn_mother',
							'first_name_father', 'last_name_father',
							'nrn_father',
							'phone_number'];

	/**
	 * Validation rules for the User model
	 * @var array
	 */
	protected $rules =
		['email' => 'required|email|unique:users',
		 'password' => 'required|min:6',
		 'password_confirmed' => 'required_with:password|same:password',
		 'first_name_mother' => 'required_without:first_name_father',
		 'last_name_mother' => 'required_with:first_name_mother',
		 'nrn_mother' => 'required_with:first_name_mother',
		 'first_name_father' => 'required_without:first_name_mother',
		 'last_name_father' => 'required_with:first_name_father',
		 'nrn_father' => 'required_with:first_name_mother',
		 'phone_number' => 'required'];
}