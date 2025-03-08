<?php

namespace Database\Seeders;

use App\Models\Nav;
use NovaLite\Database\Seeder;

class NavSeeder extends Seeder
{
    private array $nav = [
        [
            'name' => 'Home',
            'route' => '/home',
            'icon_id' => 1
        ],
        [
            'name' => 'Explore',
            'route' => '/explore',
            'icon_id' => 2
        ],
        [
            'name' => 'Notifications',
            'route' => '/notifications',
            'icon_id' => 3
        ],
        [
            'name' => 'Messages',
            'route' => '/messages',
            'icon_id' => 4
        ],
        [
            'name' => 'Profile',
            'route' => '/profile',
            'icon_id' => 5
        ],
    ];
	public function run() : void
	{
		foreach ($this->nav as $nav){
            Nav::create($nav);
        }
	}
}
