<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_navs_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Nav::TABLE, function (Migration $table) {
			$table->id();
            $table->string('name', 50);
            $table->string('route', 50);
			$table->timestamps();

            $table->foreignId('icon_id')->references('icons');
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\Nav::TABLE);
	}
}
