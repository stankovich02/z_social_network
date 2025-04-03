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

        $diff = $now->getTimestamp() - $dateTime->getTimestamp();

        if ($diff < 86400) {
            return $dateTime->format('H:i');
        } elseif ($diff < 172800) {
            return "Yesterday, " . $dateTime->format('H:i');
        } else {
            return $dateTime->format('M j, Y, H:i');
        }
    }

}