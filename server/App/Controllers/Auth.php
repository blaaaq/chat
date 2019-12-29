<?php


namespace App\Controllers;

use App\Models;
use App\Traits\User;

class Auth extends \App\Core\Controller
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


    public function auth()
    {
        $this->validateParams($this->post->nick, $this->post->password);

        $user = $this->user::getUser($this->post->nick);
        if (!$user)
            die('Такого пользователя не существует!');

        if ($this->generateHash($this->post->password) != $user['password'])
            die('Пароль неверный!');

        $newSession = $this->generateSession(64);
        setcookie('session', $newSession, time() + 60*60*24*30, '/');
        $this->user->authSuccess($user['id'], $newSession);

        print json_encode(['nick'=>$user['nick'],'newSession'=>$newSession]);
    }

}
