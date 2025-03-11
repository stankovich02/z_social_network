<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_posts_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Post::TABLE, function (Migration $table) {
			$table->id();
            $table->text('content')->nullable();
			$table->timestamps();

            $table->foreignId('user_id')->references('users')->onDelete('cascade');
		});
	}

	public function down() : void
	{
		Schema::drop('posts');
	}
}
