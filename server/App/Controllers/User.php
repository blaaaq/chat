<?php


namespace App\Controllers;

use App\Models;

class User extends \App\Core\Controller
{

    public $user;

    public function index(){

         print 1;
    }

    public function index2(){

        $this->user=new Models\User();

        print count($this->user->getAll());



      //  print $this->params['id'];
    }
}