<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_posts_notifications_table
{
	public function up() : void
	{
		Schema::create(\App\Models\PostNotification::TABLE, function (Migration $table) {
            $table->foreignId('post_id')->references('posts')->onDelete('cascade');
            $table->foreignId('notification_id')->references('notifications')->onDelete('cascade');

            $table->primary(['post_id', 'notification_id']);
		});
	}

	public function down() : void
	{
		Schema::drop('posts_notifications');
	}
}
