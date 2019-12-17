<?php


namespace App\Controllers;

use App\Models;

class AuthCheck extends \App\Core\Controller
{
    private $user;
    
    public function __construct($params)
    {
        parent::__construct($params);
    
        $this->user = new Models\User();
    }


    public function check()
    {
        if (empty($this->cookies->session))
            return;
        
        $user = $this->user->checkAuth($this->cookies->session);
        if (!$user)
            return;
         
        print json_encode(['nick' => $user['nick'], 'newSession' => $user['session']]);
    }
}