<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_notifications_table
{
	public function up() : void
	{
		Schema::create('notifications', function (Migration $table) {
			$table->id();
            $table->foreignId('notification_type_id')->references('notification_types')->onDelete('cascade');
            $table->foreignId('user_id')->references('users')->onDelete('cascade');
            $table->foreignId('target_user_id')->references('users')->onDelete('cascade');
            $table->string('link');
            $table->boolean('is_read')->default(0);
		});
	}

	public function down() : void
	{
		Schema::drop('notifications');
	}
}
