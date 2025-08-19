<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class add_content_index_to_comments_table
{
	public function up() : void
	{
		Schema::modify(\App\Models\Comment::TABLE, function (Migration $table) {
			$table->index('content');
		});
	}

	public function down() : void
	{
		Schema::modify(\App\Models\Comment::TABLE, function (Migration $table) {
			$table->dropIndex('content');
		});
	}
}
