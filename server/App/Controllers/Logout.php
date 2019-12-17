<?php


namespace App\Controllers;

use App\Models;

class Logout extends \App\Core\Controller
{
    private $user;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->user = new Models\User();
    }


    public function logout()
    {
        if (empty($this->cookies->session))
            return;

        $user = $this->user->logout($this->cookies->session);
        if (!$user)
            return;

        setcookie('session', '', time() - 60*60*24*30, '/');
        print json_encode(['success'=>'ok']);
    }

}
