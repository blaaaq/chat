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

        if (!preg_match('|^[а-яa-z0-9_]{2,30}$|iu',$this->post->nick))
            die('Ник может состоять из букв русского, английского алфавитов, цифр, знака _ и длины от 2 до 30 символов!');

        $len_password = mb_strlen($this->post->password);
        if ($len_password < 3 or $len_password > 60)
            die('Пароль должен быть не короче 3-ех и не больше 60 символов!');


        $this->user = new Models\User();

        $user = $this->user->getUser($this->post->nick);
        if ($user)
            die('Такой ник уже занят!');


        $password = password_hash($this->post->password, PASSWORD_DEFAULT);
        $new_session = $this->generateSession(64);

        $register = $this->user->Register($this->post->nick, $password ,$new_session);
        if (!$register)
            return;


        setcookie('session', $new_session, time() + 60 * 60 * 24 * 30, '/');


        print json_encode(['nick' => $this->post->nick, 'newSession' => $new_session]);
    }


}