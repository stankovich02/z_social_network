<?php

use NovaLite\Database\Migrations\Migration;
use NovaLite\Database\Migrations\Schema;

class create_users_followers_table
{
	public function up() : void
	{
		Schema::create(\App\Models\UserFollower::TABLE, function (Migration $table) {
			$table->foreignId('user_id')->references('users')->onDelete('cascade');
            $table->foreignId('follower_id')->references('users')->onDelete('cascade');
			$table->timestamps();

            $table->primary(['user_id', 'follower_id']);
		});
	}

	public function down() : void
	{
		Schema::drop(\App\Models\UserFollower::TABLE);
	}
}
