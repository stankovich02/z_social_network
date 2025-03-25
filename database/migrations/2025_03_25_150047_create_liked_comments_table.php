<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_liked_comments_table
{
	public function up() : void
	{
		Schema::create(\App\Models\LikedComment::TABLE, function (Migration $table) {
			$table->foreignId('comment_id')->references('comments')->onDelete('cascade');
            $table->foreignId('user_id')->references('users')->onDelete('cascade');
			$table->timestamps();

            $table->primary(['comment_id', 'user_id']);
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\LikedComment::TABLE);
	}
}
