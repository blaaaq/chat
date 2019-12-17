<?php


namespace App\Traits;


trait User
{
    public function validatePassword($password){
        $len_password = mb_strlen($password);
        if ($len_password < 3 or $len_password > 60)
            return 'Пароль должен быть не короче 3-ех и не больше 60 символов!';
    }

    public function validateNick($nick){
        if (!preg_match('|^[а-яa-z0-9_]{2,30}$|iu',$nick))
            return 'Ник может состоять из букв русского, английского алфавитов, цифр, знака _ и длины от 2 до 30 символов!';
    }

    private function validateNickPassword($nick, $password)
    {
        if (empty($nick) or empty($password))
            return 'Вы что-то забыли...';

        $nick_error = $this->validateNick($nick);
        if(!empty($nick_error))
            return $nick_error;

        $password_error_ = $this->validatePassword($password);
        if(!empty($password_error_))
            return $password_error_;
    }


    public function generateHash($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function generateSession($len){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $session = '';
        for($i = 0; $i < $len; $i++) {
            $char = $chars[mt_rand(0, strlen($chars) - 1)];
            $session .= $char;
        }

        return $session;
    }

}
