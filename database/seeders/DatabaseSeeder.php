<?php

namespace Database\Seeders;

use NovaLite\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IconSeeder::class,
            RoleSeeder::class,
            NavSeeder::class,
            NotificationTypeSeeder::class
        ]);
    }
}