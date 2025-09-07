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
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/'
		];
	}
    protected function customMessages(): array
    {
        return [
            'full_name.required' => 'Full name is required.',
            'full_name.regex' => 'Full name must contain only letters and spaces, with each part between 3 and 16 characters long.',
            'username.required' => 'Username is required.',
            'username.regex' => 'Username must be 3-50 characters long and contain only lowercase letters and numbers.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.regex' => 'Password must be at least 8 characters long, including at least one uppercase letter, one lowercase letter, and one number.'
        ];
    }
}
