<?php

namespace App\Controllers;

use Delight\Auth\AttemptCancelledException;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\TooManyRequestsException;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

class AuthController extends AbstractController
{
    public function index()
    {
        echo $this->templates->render('page_login');
    }

    public function login()
    {
        $this->action(function () {
            $this->auth->login($_POST['email'], $_POST['password']);
        });
        header("Location: /");
    }

    public function logout()
    {
        $this->action(function () {
            $this->auth->logOut();
        });
        header("Location: /");
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
            case ($e instanceof EmailNotVerifiedException):
                Flash::error('Такой пользователь уже существует');
                break;
            case ($e instanceof TooManyRequestsException):
                Flash::error('Слишком много запросов');
                break;
        }
        echo $this->templates->render('page_login');
        exit;
    }
}