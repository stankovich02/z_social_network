<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class add_message_index_to_messages_table
{
	public function up() : void
	{
		Schema::modify(\App\Models\Message::TABLE, function (Migration $table) {
			$table->index('message');
		});
	}

	public function down() : void
	{
		Schema::modify(\App\Models\Message::TABLE, function (Migration $table) {
			$table->dropIndex('message');
		});
	}
}
