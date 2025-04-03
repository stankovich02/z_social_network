<?php

namespace App\Chat;

use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class MyChat implements MessageComponentInterface, \Ratchet\MessageComponentInterface
{
    protected $clients;
    protected $pdo;

    public function __construct() {
        $this->clients = [];
        $this->pdo = new \PDO("mysql:host=localhost;dbname=z_social_network", "root", "");
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
        if (isset($data['sent_from']) && isset($data['sent_to']) && isset($data['message'])) {
            $sentFrom = $data['sent_from'];
            $sentTo = $data['sent_to'];
            $message = $data['message'];
            $conversationId = $data['conversation_id'];
            $otherUserColumn = $data['other_user_column'];
            $createdAt = $data['created_at'];

            $messageId = $this->saveMessageToDatabase($sentFrom, $sentTo, $message,$createdAt, $conversationId, $otherUserColumn);

            if (isset($this->clients[$sentTo])) {
                $this->clients[$sentTo]->send(json_encode([
                    'message_id' => $messageId,
                    'sent_from' => $sentFrom,
                    'sent_to' => $sentTo,
                    'message' => $message,
                    'created_at' => $createdAt,
                ]));
            }
            $this->clients[$sentFrom]->send(json_encode([
                'message_id' => $messageId,
                'sent_from' => $sentFrom,
                'sent_to' => $sentTo,
                'message' => $message,
                'created_at' => $createdAt,
            ]));
        }
        if(isset($data['viewed'])){
            $this->markMessageAsSeen($data);
        }
    }

    private function saveMessageToDatabase($sentFrom,$sentTo, $message, $createdAt, $conversationId, $otherUserColumn) : int
    {
        $stmt = $this->pdo->prepare("INSERT INTO messages (conversation_id, sent_from,sent_to, message, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$conversationId, $sentFrom, $sentTo, $message, $createdAt]);
        $insertedId = $this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare("UPDATE conversations SET last_message_time = ?, last_message = ? WHERE user_id = ? AND other_user_id = ?");
        if($otherUserColumn == 'user_id'){
            $stmt->execute([$createdAt, $message, $sentTo, $sentFrom]);
        }
        else{
            $stmt->execute([$createdAt, $message, $sentFrom, $sentTo]);
        }
        return $insertedId;
    }
    private function markMessageAsSeen($data) : void
    {
        $sentFrom = $data['sent_from'];
        $messageId = $data['message_id'];
        $updatedAt = $data['updated_at'];

        $stmt = $this->pdo->prepare("UPDATE messages SET is_read = 1, updated_at = ? WHERE id = ?");
        $stmt->execute([$updatedAt, $messageId]);

        if (isset($this->clients[$sentFrom])) {
            $this->clients[$sentFrom]->send(json_encode([
                'message_id' => $messageId,
                'viewed' => true,
                'updated_at' => $updatedAt,
            ]));
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