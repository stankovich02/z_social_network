<?php

namespace App\Middlewares;

use NovaLite\Http\Middlewares\MiddlewareInterface;

class IsLoggedIn implements MiddlewareInterface
{
	public function handle()
	{
		if(!session()->has('user')){
            return redirect()->to('start');
        }
        return true;
	}
}
