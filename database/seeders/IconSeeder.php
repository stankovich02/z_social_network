<?php

namespace Database\Seeders;

use App\Models\Icon;
use NovaLite\Database\Seeder;

class IconSeeder extends Seeder
{
    private array $icons = [
        [
            'divClass' => 'icon-embed-medium link-icon',
            'className' => 'iconify iconify--ic',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M10 20v-6h4v6h5v-8h3L12 3L2 12h3v8z',
        ],
        [
            'divClass' => 'icon-embed-medium link-icon',
            'className' => 'iconify iconify--bx',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M10 18a7.95 7.95 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.95 7.95 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8s3.589 8 8 8m0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6s-6-2.691-6-6s2.691-6 6-6',
        ],
        [
            'divClass' => 'icon-embed-medium link-icon',
            'className' => 'iconify iconify--bx',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A1 1 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a1 1 0 0 0-.293-.707zM19 17H5v-.586l1.707-1.707A1 1 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22',
        ],
        [
            'divClass' => 'icon-embed-medium link-icon',
            'className' => 'iconify iconify--ic',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z',
        ],
        [
            'divClass' => 'icon-embed-medium link-icon',
            'className' => 'iconify iconify--bx',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2S7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z',
        ],
        [
            'divClass' => 'user-icon',
            'className' => 'iconify iconify--bx',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2S7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z',
        ],
        [
            'divClass' => 'repost-icon',
            'className' => 'iconify iconify--bx',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M19 7a1 1 0 0 0-1-1h-8v2h7v5h-3l3.969 5L22 13h-3zM5 17a1 1 0 0 0 1 1h8v-2H7v-5h3L6 6l-4 5h3z',
        ],
        [
            'divClass' => 'heart-icon',
            'className' => 'iconify iconify--fe',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M12 20c-2.205-.48-9-4.24-9-11a5 5 0 0 1 9-3a5 5 0 0 1 9 3c0 6.76-6.795 10.52-9 11',
        ],
        [
            'divClass' => 'more-options',
            'className' => 'iconify iconify--ph',
            'viewBox' => '0 0 256 256',
            'path_d' => 'M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16',
        ],
        [
            'divClass' => 'close-icon',
            'className' => 'iconify iconify--ic',
            'viewBox' => '0 0 24 24',
            'path_d' => 'M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z'
        ]
    ];
	public function run() : void
	{
		foreach ($this->icons as $icon) {
            Icon::create($icon);
        }
	}
}
