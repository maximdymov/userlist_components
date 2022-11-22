<?php

namespace App\Controllers;

use Delight\Auth\Auth;
use Delight\Auth\Role;
use League\Plates\Engine;
use Model\User\UserRepository;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->action(function () {
            if (!$this->auth->isLoggedIn()) {
                header('Location: auth');
            }

            $users = $this->repo->getAllUsers();

            echo $this->templates->render('users', ['users' => $users, 'thisUser' => $this->auth]);
        });
    }

    protected function showError(\Exception $e)
    {
        // TODO: Implement showError() method.
    }
}