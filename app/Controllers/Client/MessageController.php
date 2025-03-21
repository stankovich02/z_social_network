<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;
use NovaLite\Views\View;

class MessageController extends Controller
{
    public function index() : View
    {
        return view('pages.client.messages');
    }
}
