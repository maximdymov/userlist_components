<?php

namespace App\Controllers;

use Delight\Auth\Auth;
use League\Plates\Engine;

abstract class AbstractController
{
    protected Auth $auth;
    protected Engine $templates;

    public function __construct()
    {
        $this->templates = new Engine('app/views');
        $this->auth = new Auth(new \PDO("mysql:host=localhost;dbname=userlist", 'root', '1234')) ;
    }
}