<?php

namespace App\Traits;

use DateTime;
use DateTimeZone;

trait CalculateDate
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
  /*  public function calculateMessageDate($date) : string
    {
        $timestamp = strtotime($date);
        $now = time();
        $diff = $now - $timestamp;
        if ($diff < 86400) {
            return date("g:i A", $timestamp);
        } elseif ($diff < 172800) {
            return "Yesterday, " . date("g:i A", $timestamp);
        } else {
            return date("M j, Y, g:i A", $timestamp);
        }
    }*/
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
        //under 60s -> "now", 1-60 mins -> "x m", 1-24h -> "x h", 1-7d -> "x d", 7d+ -> "M j"
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


}