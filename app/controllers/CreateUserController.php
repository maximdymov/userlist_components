<?php

namespace App\Controllers;

use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\Role;
use Delight\Auth\UserAlreadyExistsException;
use Model\User\EmployeeInfo;
use Model\User\User;
use Model\User\WebInfo;
use Tamtamchik\SimpleFlash\Flash;

class CreateUserController extends AbstractController
{
    public function index()
    {
        if ($this->auth->isLoggedIn() && $this->auth->hasRole(Role::ADMIN)) {
            echo $this->templates->render('create_user');
        } else {
            header('Location: /');
        }
    }

    public function createUser()
    {
        $user = new User (
            $_POST['name'],
            new EmployeeInfo('', $_POST['address'], $_POST['phone']),
            new WebInfo($_POST['email'], $_POST['password'], $_POST['status'], $_POST['img'])
        );

        try {
            $this->auth->admin()->createUser(
                $user->email(), $user->password()
            );
        } catch (\Exception $e) {
            $this->showError($e);
        }

        $this->repo->saveUser($user);

        Flash::success('Добавлен новый пользователь.');
        header('Location: /');

    }

    private function showError(\Exception $e)
    {
        switch ($e) {
            case ($e instanceof InvalidEmailException):
                Flash::error('Некорректная почта');
                break;
            case ($e instanceof InvalidPasswordException):
                Flash::error('Некорректный пароль');
                break;
            case ($e instanceof UserAlreadyExistsException):
                Flash::error('Такой пользователь уже существует');
                break;
        }
        echo $this->templates->render('create_user');
        exit;
    }


}