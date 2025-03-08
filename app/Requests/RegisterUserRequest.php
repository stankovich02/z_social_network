<?php

namespace App\Requests;

use NovaLite\Validations\FormRequest;

class RegisterUserRequest extends FormRequest
{
	protected function rules() : array
	{
		return [
			'full_name' => 'required|regex:/(^[A-Za-z]{3,16})([ ]{0,1})([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})/',
            'username' => 'required|regex:/^[a-z0-9]{3,50}$/|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
		];
	}
}
