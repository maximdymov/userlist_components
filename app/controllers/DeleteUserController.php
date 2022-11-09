<?php

namespace App\Controllers;

use Tamtamchik\SimpleFlash\Flash;

class DeleteUserController extends AbstractController
{
    public function index($id) {
        $this->redirectIfForbidden($id);

        $this->auth->admin()->deleteUserById($id);
        $this->repo->deleteUser($id);

        Flash::success('Пользователь удален');
        header('Location: /');
    }
}