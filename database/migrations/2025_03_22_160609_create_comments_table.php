<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_comments_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Comment::TABLE, function (Migration $table) {
			$table->id();
            $table->text('content');
            $table->foreignId('post_id')->references('posts')->onDelete('cascade');
            $table->foreignId('user_id')->references('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\Comment::TABLE);
	}
}
