<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.client.home');
    }
}
