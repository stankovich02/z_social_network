<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_image_posts_table
{
	public function up() : void
	{
		Schema::create('image_posts', function (Migration $table) {
			$table->id();
            $table->string('image');
			$table->timestamps();

            $table->foreignId('post_id')->references('posts')->onDelete('cascade');
		});
	}

	public function down() : void
	{
		Schema::drop('image_posts');
	}
}
