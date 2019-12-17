<?php


namespace App\Controllers;

use App\Models;

class LastMessages extends \App\Core\Controller
{
    private $messages;
    private $user;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->messages = new Models\Messages();
        $this->user = new Models\User();
    }


    public function view()
    {
        $messages = $this->messages->getLastMessages(10);

        $send_data=[];
        foreach ($messages as $data) {
            $sender = $this->user->getUserFromId($data['id_sender']);
            $files = $this->messages->getMessageFiles($data['id']);

            $send_data[] = [
                'id' => $data['id'],
                'senderId' => $sender['id'],
                'senderNick' => $sender['nick'],
                'text' => $data['text'],
                'files' => $files,
                'time' => $data['time']
            ];
        }

        print json_encode($send_data);
    }

}
