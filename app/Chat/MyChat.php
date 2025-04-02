<?php

namespace App\Chat;

use Ratchet\ConnectionInterface;
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
        $conversationId = $data['conversation_id'];
        $otherUserColumn = $data['other_user_column'];
        $createdAt = $data['created_at'];

        echo "User $sentFrom sent: $message\n";
        $this->saveMessageToDatabase($sentFrom, $sentTo, $message,$createdAt, $conversationId, $otherUserColumn);

        if (isset($this->clients[$sentTo])) {
            $this->clients[$sentTo]->send(json_encode([
                'sent_from' => $sentFrom,
                'sent_to' => $sentTo,
                'message' => $message,
                'created_at' => $createdAt,
            ]));
        }
        $this->clients[$sentFrom]->send(json_encode([
            'sent_from' => $sentFrom,
            'sent_to' => $sentTo,
            'message' => $message,
            'created_at' => $createdAt,
        ]));
    }

    private function saveMessageToDatabase($sentFrom,$sentTo, $message, $createdAt, $conversationId, $otherUserColumn)
    {
        $pdo = new \PDO("mysql:host=localhost;dbname=z_social_network", "root", "");
        $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, sent_from,sent_to, message, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$conversationId, $sentFrom, $sentTo, $message, $createdAt]);
        $stmt = $pdo->prepare("UPDATE conversations SET last_message_time = ?, last_message = ? WHERE user_id = ? AND other_user_id = ?");
        if($otherUserColumn == 'user_id'){
            $stmt->execute([$createdAt, $message, $sentTo, $sentFrom]);
        }
        else{
            $stmt->execute([$createdAt, $message, $sentFrom, $sentTo]);
        }
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