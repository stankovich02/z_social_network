<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_left_conversations_table
{
	public function up() : void
	{
		Schema::create(\App\Models\LeftConversation::TABLE, function (Migration $table) {
			$table->foreignId('conversation_id')->references('conversations')->onDelete('cascade');
            $table->foreignId('user_id')->references('users')->onDelete('cascade');
			$table->timestamp('left_at');

            $table->primary(['conversation_id', 'user_id']);
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\LeftConversation::TABLE);
	}
}
