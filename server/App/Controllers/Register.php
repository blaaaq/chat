<?php


namespace App\Controllers;

use App\Models;
use App\Traits\User;

class Register extends \App\Core\Controller
{
    use User;

    private $user;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->user = new Models\User();
    }


    private function validateParams($nick, $password)
    {
        $error = $this->validateNickPassword($this->post->nick, $this->post->password);
        if (!empty($error))
            die($error);
    }

    private function checkNick($nick)
    {
        $user = $this->user->getUser($nick);
        if ($user)
            die('Такой ник уже занят!');
    }


    public function register()
    {
        $this->validateParams($this->post->nick, $this->post->password);
        $this->checkNick($this->post->nick);

        $password = $this->generateHash($this->post->password);
        $newSession = $this->generateSession(64);

        $register = $this->user->Register($this->post->nick, $password ,$newSession);
        if (!$register)
            return;


        setcookie('session', $newSession, time() + 60 * 60 * 24 * 30, '/');

        print json_encode(['nick' => $this->post->nick, 'newSession' => $newSession]);
    }

}
