<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_roles_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Role::TABLE, function (Migration $table) {
			$table->id();
            $table->string('name',50);
			$table->timestamps();
		});
	}

	public function down() : void
	{
		Schema::drop('roles');
	}
}
