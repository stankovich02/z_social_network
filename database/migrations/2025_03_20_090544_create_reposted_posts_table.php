<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_reposted_posts_table
{
	public function up() : void
	{
		Schema::create('reposted_posts', function (Migration $table) {
            $table->foreignId('user_id')->references('users')->onDelete('cascade');
            $table->foreignId('post_id')->references('posts')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'post_id']);
		});
	}

	public function down() : void
	{
		Schema::drop('reposted_posts');
	}
}
