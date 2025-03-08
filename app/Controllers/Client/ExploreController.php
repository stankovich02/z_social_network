<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;

class ExploreController extends Controller
{
    public function index() : string
    {
        return view('pages.client.explore');
    }
}
