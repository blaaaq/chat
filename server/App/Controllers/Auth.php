<?php


namespace App\Controllers;

use App\Models;

class Auth extends \App\Core\Controller
{

    public $user;


    public function auth(){
        if(empty($this->post->nick))
            return;


        $this->user=new Models\User();

        $user = $this->user->getUser($this->post->nick);

        if($user AND $user['password'] == $this->post->password){

            $new_session=$this->generateSession(64);

            setcookie('session', $new_session, time() + 60*60*24*30, '/');
            $this->user->authSuccess($user['id'],$new_session);

            print json_encode(['nick'=>$user['nick'],'newSession'=>$new_session]);
        }



    }
}