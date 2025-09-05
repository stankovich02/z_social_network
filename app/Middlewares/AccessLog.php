<?php

namespace App\Middlewares;

use NovaLite\Http\Middlewares\MiddlewareInterface;

class AccessLog implements MiddlewareInterface
{
	public function handle()
	{
		$accessLogFile = fopen(__DIR__ . '/../../logs/AccessLog.txt', 'a');

        $accessLogEntry = date('Y-m-d H:i:s') . ' ' . $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['REQUEST_METHOD'] . PHP_EOL;

        fwrite($accessLogFile, $accessLogEntry);

        fclose($accessLogFile);
	}
}
