<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_conversations_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Conversation::TABLE, function (Migration $table) {
			$table->id();
            $table->foreignId('user_id')->references('users')->onDelete('cascade');
            $table->foreignId('other_user_id')->references('users')->onDelete('cascade');
            $table->string('last_message');
            $table->timestamp('last_message_time')->nullable();
			$table->timestamps();
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\Conversation::TABLE);
	}
}
