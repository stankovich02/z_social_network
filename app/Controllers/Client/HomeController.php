<?php

namespace App\Controllers\Client;

use App\Models\Nav;
use NovaLite\Http\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.client.home');
    }
}
