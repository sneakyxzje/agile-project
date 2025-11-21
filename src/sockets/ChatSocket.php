<?php 

namespace App\sockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class ChatSocket implements MessageComponentInterface {
    protected $clients;

    protected $userMapping = [];

    public function __construct() {
        $this -> clients = new \SplObjectStorage;
        echo "ChatSockets Class started!..\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New Connection: ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if(isset($data['type']) && $data['type'] == 'register') {
            $userId = $data['user_id'];
            $this->userMapping[$userId] = $from;
        }
    }

    public function onRedisMessage($payload) {
        echo "Redis Push: $payload\n";

        $data = json_decode($payload, true);

        if($data['type'] === 'chat_messages') {
            $receiverId = $data['to_id'];

            if(isset($this->userMapping[$receiverId])) {
                $conn = $this->userMapping[$receiverId];
                $conn->send($payload);
            } else {
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        foreach ($this->userMapping as $uid => $userConn) {
            if ($userConn === $conn) {
                unset($this->userMapping[$uid]);
                break;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
} 