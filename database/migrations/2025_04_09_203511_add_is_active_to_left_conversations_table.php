<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class add_is_active_to_left_conversations_table
{
	public function up() : void
	{
		Schema::modify(\App\Models\LeftConversation::TABLE, function (Migration $table) {
			$table->boolean('is_active')->default(0);
		});
	}

	public function down() : void
	{
		Schema::modify(\App\Models\LeftConversation::TABLE, function (Migration $table) {
			$table->dropColumn('is_active');
		});
	}
}
