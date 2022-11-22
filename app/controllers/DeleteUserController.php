<?php

namespace App\Controllers;

use Tamtamchik\SimpleFlash\Flash;

class DeleteUserController extends AbstractController
{
    public function index($id)
    {
        $this->action(function () use ($id) {
            $this->redirectIfForbidden($id);

            $this->auth->admin()->deleteUserById($id);
            $this->repo->deleteUser($id);

            Flash::success('Пользователь удален');
            header('Location: /');
        });
    }

    protected function showError(\Exception $e)
    {
        // TODO: Implement showError() method.
    }
}