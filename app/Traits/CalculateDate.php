<?php

namespace App\Traits;

trait CalculateDate
{
    public function calculatePostedDate($createdAt)
    {
        $timestamp = strtotime($createdAt);
        $now = time();
        $diff = $now - $timestamp;

        if ($diff < 60) {
            return "now";
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . " min" . ($minutes > 1 ? "s" : "");
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . " hour" . ($hours > 1 ? "s" : "");
        } else {
            return date("M j", $timestamp);
        }
    }
}