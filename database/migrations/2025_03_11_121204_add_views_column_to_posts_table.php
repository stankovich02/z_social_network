<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class add_views_column_to_posts_table
{
	public function up() : void
	{
		Schema::modify(\App\Models\Post::TABLE, function (Migration $table) {
			$table->integer('views')->default(0)->after('content');
		});
	}

	public function down() : void
	{
		Schema::modify(\App\Models\Post::TABLE, function (Migration $table) {
			$table->dropColumn('views');
		});
	}
}
