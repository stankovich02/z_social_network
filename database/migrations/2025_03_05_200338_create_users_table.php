<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_users_table
{
	public function up() : void
	{
		Schema::create('users', function (Migration $table) {
			$table->id();
            $table->string('full_name', 50);
            $table->string('username', 50)->unique();
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('biography', 160)->nullable();
            $table->string('photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('token', 30)->nullable()->unique();
            $table->boolean('is_active')->default(0);
			$table->timestamps();

            $table->foreignId('role_id')->references('roles');
		});
	}

	public function down() : void
	{
		Schema::drop('users');
	}
}
