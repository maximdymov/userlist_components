<?php

namespace App\Controllers;

class ProfileController extends AbstractController
{
    public function index($id)
    {
        $this->action(function () use ($id) {
            $user = $this->repo->getUserById($id);
            echo $this->templates->render('profile', ['id' => $id, 'user' => $user]);
        });
    }

    protected function showError(\Exception $e)
    {
        // TODO: Implement showError() method.
    }
}