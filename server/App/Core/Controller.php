<?php

namespace App\Core;



class Controller
{
    protected $params;
    protected $post;
    protected $cookies;
    public function __construct($params)
    {
        $this->stopNoAjax();

        $this->params = $params;
        foreach ($_POST as $key=>$value) {
            $this->post=json_decode($key);
        }
        $this->cookies = (object)$_COOKIE;
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

    public function stopNoAjax()
    {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']))
            die('Ошибка. Пожалуйста, вернитесь и попробуйте заного.');

        if ($_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest')
            die('Ошибка. Пожалуйста, вернитесь и попробуйте заного.');
    }

    public function __call($name, $args)
    {
        if (!method_exists($this, $name)) {
            throw new \Exception("Method $name not found in controller " . get_class($this));
        }
    }

}