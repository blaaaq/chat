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
            $this->post = json_decode($key);
        }
        $this->cookies = (object)$_COOKIE;
    }



    protected function stopNoAjax()
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