<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_viewed_posts_table
{
	public function up() : void
	{
		Schema::create(\App\Models\ViewedPost::TABLE, function (Migration $table) {
			$table->foreignId('user_id')->references('users')->onDelete('cascade');
            $table->foreignId('post_id')->references('posts')->onDelete('cascade');

            $table->primary(['user_id', 'post_id']);
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\ViewedPost::TABLE);
	}
}
