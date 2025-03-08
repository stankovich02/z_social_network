<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use NovaLite\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    private array $types = [
        [
            'text' => '{full_name} liked your post',
            'icon_id' => 8,
        ],
        [
            'text' => '{full_name} reposted your post',
            'icon_id' => 7,
        ],
        [
            'text' => '{full_name} liked your reply',
            'icon_id' => 8,
        ],
        [
            'text' => '{full_name} followed you',
            'icon_id' => 6,
        ],
        [
            'text' => '{full_name} commented on your post',
            'icon_id' => 6,
        ]
    ];
	public function run() : void
	{
		foreach ($this->types as $type) {
            NotificationType::create($type);
        }
	}
}
