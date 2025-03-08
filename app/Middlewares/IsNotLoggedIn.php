<?php

namespace App\Middlewares;

use NovaLite\Http\Middlewares\MiddlewareInterface;
use NovaLite\Http\RedirectResponse;
use NovaLite\Routing\Router;

class IsNotLoggedIn implements MiddlewareInterface
{
	public function handle()
	{
        if(session()->has('user')){
          return redirect()->to('home');
        }
        return true;
	}
}
