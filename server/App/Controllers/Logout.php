<?php


namespace App\Controllers;

use App\Models;

class Logout extends \App\Core\Controller
{

    public $user;


    public function logout(){
        if(empty($this->cookies->session))
            return;
        $this->user=new Models\User();

        $user = $this->user->logout($this->cookies->session);
        if(!$user)
            return;

        setcookie('session', '', time() - 60*60*24*30, '/');
        print json_encode(['success'=>'ok']);
    }
}