<?php


namespace App\Controllers;

use App\Models;

class AuthCheck extends \App\Core\Controller
{

    public $user;
    

    public function check(){
        if(empty($this->cookies->session))
            return;
        
        $this->user=new Models\User();

        $user = $this->user->checkAuth($this->cookies->session);
        if(!$user)
            return;
         
        print json_encode(['nick' => $user['nick'], 'newSession' => $user['session']]);
    }
}