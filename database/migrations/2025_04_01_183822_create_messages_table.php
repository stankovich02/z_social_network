<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_messages_table
{
	public function up() : void
	{
		Schema::create(\App\Models\Message::TABLE, function (Migration $table) {
			$table->id();
            $table->foreignId('conversation_id')->references('conversations')->onDelete('cascade');
            $table->foreignId('sent_from')->references('users')->onDelete('cascade');
            $table->foreignId('sent_to')->references('users')->onDelete('cascade');
            $table->string('message');
            $table->boolean('is_read')->default(0);
			$table->timestamps();
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\Message::TABLE);
	}
}
