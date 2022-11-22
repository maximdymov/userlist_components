<?php

namespace App\Controllers;

use Delight\Auth\Auth;
use Delight\Auth\AuthError;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use Exception;
use League\Plates\Engine;
use Model\User\EmployeeInfo;
use Model\User\User;
use Model\User\UserRepository;
use Model\User\WebInfo;
use Tamtamchik\SimpleFlash\Flash;

class RegisterController extends AbstractController
{

    public function index()
    {
        echo $this->templates->render('page_register');
    }

    public function register()
    {
        $this->action(function () {
            $user = new User(
                '',
                null,
                new WebInfo($_POST['email'], $_POST['password'])
            );

            $this->auth->register(
                $user->email(),
                $user->password(),
                '',
                function ($selector, $token) {
                    $this->auth->confirmEmail($selector, $token);
                });

            $this->repo->saveUser($user);

            Flash::success('Регистрация прошла успешно');
            header('Location: auth');
        });
    }

    protected function showError(\Exception $e)
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
            case ($e instanceof TooManyRequestsException):
                Flash::error('Слишком много запросов');
                break;
        }
        echo $this->templates->render('page_register');
        exit;
    }
}

