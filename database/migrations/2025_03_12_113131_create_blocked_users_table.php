<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_blocked_users_table
{
	public function up() : void
	{
		Schema::create(\App\Models\BlockedUser::TABLE, function (Migration $table) {
			$table->foreignId('blocked_by_user_id')->references('users')->onDelete('cascade');
            $table->foreignId('blocked_user_id')->references('users')->onDelete('cascade');
			$table->timestamps();

            $table->primary(['blocked_by_user_id', 'blocked_user_id']);
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\BlockedUser::TABLE);
	}
}
