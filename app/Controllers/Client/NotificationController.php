<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;

class NotificationController extends Controller
{
    public function index() : string
    {
        return view('pages.client.notifications');
    }
}
