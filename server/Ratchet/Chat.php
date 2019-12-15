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

    public function sendError($from, $error) {
        foreach ($this->clients as $client) {
            if ($from == $client) {
                $client->send(json_encode(['error' => $error]));
                break;
            }
        }
    }

    public function checkPossibilityMessage($user, $new_message) {
        $timeLastN=$this->messages->getTimeLastMessage($user['id'], 4);
        $numLastMessagesSimilarCheck = 5;
        $messagesSimilarCheck=$this->messages->getLastUserMessages($user['id'], $numLastMessagesSimilarCheck - 1);

        $time_left = $user['time_block'] - time();
        if ($time_left > 0)
            return 'Вам осталось '.$time_left.' сек.';

        if (!empty($timeLastN['time']))
            if (time() < $timeLastN['time'] + 10) {
                $this->messages->blockUser($user['id'], 60);
                return 'Слишком быстро. Вы заблокированы на 1 минуту. Подождите...';
            }

        $num=0;
        foreach ($messagesSimilarCheck as $message) {
            if (mb_strlen($message['text']) > 10) {
                similar_text($message['text'], $new_message, $perc);
                if ($perc > 90)
                    $num++;
            }
        }
        if ($num == $numLastMessagesSimilarCheck) {
            $this->messages->blockUser($user['id'], 180);
            return 'Повторяющиеся сообщения. Вы заблокированы на 3 минуты. Подождите...';
        }
    }



    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }


    public function onMessage(ConnectionInterface $from, $message_json) {

        $message = json_decode($message_json);
        if(!isset($message->session) or !isset($message->message))
            return;

        $user = $this->user->checkAuth($message->session);
        if(!$user)
            return;

        $error = $this->checkPossibilityMessage($user, $message->message);
        if (!empty($error)) {
            $this->sendError($from, $error);
            return;
        }

        $add_msg_id = $this->messages->addMessage($user['id'], $message->message, time());
        if(!$add_msg_id)
            return;

        $files = [];
        foreach($message->files as $file)
            $files[]=['id_message' => $add_msg_id, 'hash' => $file[0], 'type' => $file[1]];

        $this->messages->addMessageFiles($files);

        $add_msg = $this->messages->getMessage($add_msg_id);
        $send_data=[
            'id' => $add_msg['id'],
            'senderId' => $user['id'],
            'senderNick' => $user['nick'],
            'text' => $add_msg['text'],
            'files' => $message->files,
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
