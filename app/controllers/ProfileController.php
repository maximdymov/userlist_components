<?php

namespace App\Controllers;

class ProfileController extends AbstractController
{
    public function index($id)
    {
        $user = $this->repo->getUserById($id);
        echo $this->templates->render('profile', ['id' => $id, 'user' => $user]);
    }

}