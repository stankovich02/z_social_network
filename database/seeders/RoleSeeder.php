<?php

namespace Database\Seeders;

use App\Models\Role;
use NovaLite\Database\Seeder;

class RoleSeeder extends Seeder
{
    private array $roles = [
        [
            'name' => 'admin',
        ],
        [
            'name' => 'user',
        ]
    ];
	public function run() : void
	{
		foreach ($this->roles as $role) {
            Role::create($role);
        }
	}
}
