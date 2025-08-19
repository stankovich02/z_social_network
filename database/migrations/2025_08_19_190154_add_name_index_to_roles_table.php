<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class add_name_index_to_roles_table
{
	public function up() : void
	{
		Schema::modify(\App\Models\Role::TABLE, function (Migration $table) {
			$table->index('name');
		});
	}

	public function down() : void
	{
		Schema::modify(\App\Models\Role::TABLE, function (Migration $table) {
			$table->dropIndex('name');
		});
	}
}
