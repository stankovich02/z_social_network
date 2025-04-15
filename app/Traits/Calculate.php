<?php

namespace App\Traits;

use DateTime;
use DateTimeZone;

trait Calculate
{
    public function calculatePostedDate($createdAt) : string
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
            return $hours . "h";
        } else {
            return date("M j", $timestamp);
        }
    }
    public function calculateMessageDate($date, $timezone = 'Europe/Belgrade') {
        $dateTime = new DateTime($date, new DateTimeZone($timezone));
        $now = new DateTime('now', new DateTimeZone($timezone));

        $yesterday = (clone $now)->modify('-1 day')->format('Y-m-d');

        $diff = $now->getTimestamp() - $dateTime->getTimestamp();

        if ($diff < 86400 && $now->format('Y-m-d') == $dateTime->format('Y-m-d')) {
            return $dateTime->format('H:i');
        } elseif ($dateTime->format('Y-m-d') === $yesterday) {
            return "Yesterday, " . $dateTime->format('H:i');
        } else {
            return $dateTime->format('M j, Y, H:i');
        }
    }
    public function calculateLastMessageDate($date) : string
    {
        $timestamp = strtotime($date);
        $now = time();
        $diff = $now - $timestamp;
        if ($diff < 60) {
            return "now";
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . "m";
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . "h";
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . "d";
        } else {
            return date("M j", $timestamp);
        }
    }
    public function calculateStatNumber($number)
    {
        if ($number < 1000) {
            return $number;
        } elseif ($number < 10000) {
            return round($number / 1000, 1) . "K";
        } elseif ($number < 100000) {
            return round($number / 1000, 1) . "K";
        } elseif ($number < 1000000) {
            return round($number / 1000, 1) . "K";
        } else {
            return round($number / 1000000, 1) . "M";
        }
    }


}