<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_notification_types_table
{
	public function up() : void
	{
		Schema::create(\App\Models\NotificationType::TABLE, function (Migration $table) {
			$table->id();
            $table->string('text',200);
			$table->timestamps();

            $table->foreignId('icon_id')->references('icons');
		});
	}

	public function down() : void
	{
		Schema::drop('notification_types');
	}
}
