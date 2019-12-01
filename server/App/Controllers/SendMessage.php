<?php

//// Dont use

namespace App\Controllers;

use App\Models;

class SendMessage extends \App\Core\Controller
{

    public $messages;
    public $user;

    public function view()
    {
        if (empty($this->cookies->session) or empty($this->post->text))
            return;

        $this->messages = new Models\Messages();
        $this->user = new Models\User();

        $user = $this->user->checkAuth($this->cookies->session);
        if(!$user)
            return;

        $add_msg_id = $this->messages->addMessage($user['id'], $this->post->text, time());


        $add_msg = $this->messages->getMessage($add_msg_id);

        $send_data[]=[
            'id' => $add_msg['id'],
            'senderId' => $user['id'],
            'senderNick' => $user['nick'],
            'text' => $add_msg['text'],
            'time' => $add_msg['time']
        ];

        print json_encode($send_data);

    }


}