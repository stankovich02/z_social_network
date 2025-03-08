<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;

class MessageController extends Controller
{
    public function index() : string
    {
        return view('pages.client.messages');
    }
}
