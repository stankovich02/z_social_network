<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_posts_comments_notifications_table
{
	public function up() : void
	{
		Schema::create(\App\Models\PostCommentNotification::TABLE, function (Migration $table) {
			$table->foreignId('comment_id')->references('comments')->onDelete('cascade');
            $table->foreignId('notification_id')->references('notifications')->onDelete('cascade');

            $table->primary(['comment_id', 'notification_id']);
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\PostCommentNotification::TABLE);
	}
}
