<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;

class ProfileController extends Controller
{
    public function index() : string
    {
        return view('pages.client.profile');
    }
}
