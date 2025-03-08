<?php

namespace App\Requests;

use NovaLite\Validations\FormRequest;

class LoginUserRequest extends FormRequest
{
	protected function rules() : array
	{
		return [
            'username' => 'required|regex:/^[a-z0-9]{3,50}$/',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
		];
	}
}
