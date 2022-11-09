<?php

namespace App\Controllers;

use Delight\Auth\Auth;
use Delight\Auth\Role;
use League\Plates\Engine;
use Model\User\UserRepository;
use Tamtamchik\SimpleFlash\Flash;

abstract class AbstractController
{
    protected Auth $auth;
    protected Engine $templates;
    protected UserRepository $repo;

    public function __construct(Engine $templates, Auth $auth, UserRepository $repo)
    {
        $this->templates = $templates;
        $this->auth = $auth;
        $this->repo = $repo;
    }

    protected function redirectIfForbidden($id) {
        if ($this->canEdit($id) == false) {
            Flash::error('Отказано в доступе');
            header('Location: /');
            exit;
        }
    }

    protected function canEdit($id): bool
    {
        return ($this->auth->id() == $id || $this->auth->hasRole(Role::ADMIN));
    }
}