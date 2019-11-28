<?php


namespace App\Controllers;

use App\Models;

class Register extends \App\Core\Controller
{

    public $user;


    public function register()
    {
        if (empty($this->post->nick))
            return;


        $this->user = new Models\User();

        $user = $this->user->getUser($this->post->nick);
        if ($user)
            return;


        $new_session = $this->generateSession(64);

        $register = $this->user->Register($this->post->nick, $this->post->password,$new_session);
        if (!$register)
            return;


        setcookie('session', $new_session, time() + 60 * 60 * 24 * 30, '/');


        print json_encode(['nick' => $this->post->nick, 'newSession' => $new_session]);
    }


}