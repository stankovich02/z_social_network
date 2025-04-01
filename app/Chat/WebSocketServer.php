<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Chat\MyChat;

require dirname(__DIR__,2 ) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyChat()
        )
    ),
    8081
);

echo "WebSocket server started on port 8081...\n";
$server->run();