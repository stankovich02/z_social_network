<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Nav extends Model
{
    const TABLE = 'navs';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'name',
        'route',
        'icon_id',
    ];

    public function icon() : BelongsTo
    {
        return $this->belongsTo(Icon::class, 'icon_id', 'id');
    }

    public static function getActivePathD($nav) : string {
        $url = $_SERVER['REQUEST_URI'];
        switch ($url) {
            case $url == "/home" && $nav->name == "Home":
                $pathD = "M10 20v-6h4v6h5v-8h3L12 3L2 12h3v8z";
                break;
            case ($url == "/explore" || str_contains($url, "/explore")) && $nav->name == "Explore":
                $pathD = "M10 2c-4.411 0-8 3.589-8 8s3.589 8 8 8a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8z";
                break;
            case ($url == "/messages" || str_contains($url, "/messages")) && $nav->name == "Messages":
                $pathD = "M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z";
                break;
            case $url == "/notifications" && $nav->name == "Notifications":
                $pathD = "M12 22a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22zm7-7.414V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v4.586l-1.707 1.707A.996.996 0 0 0 3 17v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-1a.996.996 0 0 0-.293-.707L19 14.586z";
                break;
            case $url == "/" . session()->get('user')->username && $nav->name == "Profile":
                $pathD = "M7.5 6a4.5 4.5 0 1 1 9 0a4.5 4.5 0 0 1-9 0M3.751 20.105a8.25 8.25 0 0 1 16.498 0a.75.75 0 0 1-.437.695A18.7 18.7 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695";
                break;
            default:
                $pathD = $nav->icon->path_d;
                break;
        }
        return $pathD;
    }
}
