<?php

namespace Ratchet;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\Models\Messages;
use App\Models\User;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $user;
    protected $messages;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        $this->messages = new Messages();
        $this->user = new User();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }


    public function onMessage(ConnectionInterface $from, $message_json) {

        $headers_cookies = $from->httpRequest->getHeader('Cookie');
        if(!count($headers_cookies))
            return;

        $cookies = \GuzzleHttp\Psr7\parse_header($headers_cookies)[0];
        if(empty($cookies['session']))
            return;

        $message = json_decode($message_json);
        $user = $this->user->checkAuth($cookies['session']);
        if(!$user or !isset($message->message))
            return;

        $add_msg_id = $this->messages->addMessage($user['id'], $message->message, time());
        if(!$add_msg_id)
            return;

        $add_msg = $this->messages->getMessage($add_msg_id);
        $send_data=[
            'id' => $add_msg['id'],
            'senderId' => $user['id'],
            'senderNick' => $user['nick'],
            'text' => $add_msg['text'],
            'time' => $add_msg['time']
        ];

        foreach ($this->clients as $client) {
                $client->send(json_encode($send_data));
        }
    }


    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}