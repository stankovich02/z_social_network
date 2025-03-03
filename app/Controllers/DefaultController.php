<?php

namespace App\Controllers;

use NovaLite\Http\Controller;

class DefaultController extends Controller
{
    private array $nav = [
        ['name' => 'Home', 'route' => '/'],
        ['name' => 'Explore', 'route' => '/explore'],
        ['name' => 'Notifications', 'route' => '/notifications'],
        ['name' => 'Messages', 'route' => '/messages'],
        ['name' => 'Profile', 'route' => '/profile'],
    ];
}