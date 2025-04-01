<?php

namespace App\Chat;

use App\Models\Message;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class MyChat implements MessageComponentInterface, \Ratchet\MessageComponentInterface
{
    protected $clients;

    public function __construct() {
        $this->clients = [];
    }
    function onOpen(ConnectionInterface $conn)
    {
        $conn->send(json_encode(['type' => 'request_user_id']));
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        if (isset($data['user_id'])) {
            $this->clients[$data['user_id']] = $from;
            echo "User {$data['user_id']} connected.\n";
            return;
        }
        if (!isset($data['sent_from']) || !isset($data['sent_to']) || !isset($data['message'])) {
            return;
        }

        $sentFrom = $data['sent_from'];
        $sentTo = $data['sent_to'];
        $message = $data['message'];

        echo "User $sentFrom sent: $message\n";

        $this->saveMessageToDatabase($sentFrom, $sentTo, $message);

        if (isset($this->clients[$sentTo])) {
            $this->clients[$sentTo]->send(json_encode([
                'sent_from' => $sentFrom,
                'sent_to' => $sentTo,
                'message' => $message
            ]));
        }
    }

    private function saveMessageToDatabase($sentFrom,$sentTo, $message) {
        $pdo = new \PDO("mysql:host=localhost;dbname=z_social_network", "root", "");
        $stmt = $pdo->prepare("INSERT INTO messages (sent_from,sent_to, message, created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$sentFrom, $sentTo, $message,date('Y-m-d H:i:s')]);
    }

    function onClose(ConnectionInterface $conn)
    {
        foreach ($this->clients as $userId => $client) {
            if ($client === $conn) {
                unset($this->clients[$userId]);
                echo "User $userId disconnected.\n";
                break;
            }
        }
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}