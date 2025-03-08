<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_icons_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Icon::TABLE, function (Migration $table) {
			$table->id();
            $table->string('divClass', 150);
            $table->string('className', 150);
            $table->text('path_d');
            $table->string('viewBox', 100);
			$table->timestamps();
		});
	}

	public function down() : void
	{
		Schema::drop('icons');
	}
}
