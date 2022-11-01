<?php

namespace App\Controllers;

use Delight\Auth\AttemptCancelledException;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;
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
        try {
            $this->auth->login($_POST['email'], $_POST['password']);
        } catch (\Delight\Auth\InvalidEmailException $e) {
            Flash::error('Wrong email address');
            echo $this->templates->render('page_login');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            Flash::error('Wrong password');
            echo $this->templates->render('page_login');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            Flash::error('Email not verified');
            echo $this->templates->render('page_login');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            Flash::error('Too many requests');
            echo $this->templates->render('page_login');
        }

        header("Location: /");
    }

    public function logout() {
        $this->auth->logOut();
        header("Location: /");
    }
}