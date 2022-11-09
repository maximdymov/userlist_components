<?php

namespace App\Controllers;

use Model\User\EmployeeInfo;
use Model\User\User;
use Model\User\UserRepository;
use Model\User\WebInfo;
use Tamtamchik\SimpleFlash\Flash;

class EditController extends AbstractController
{

    public function editInfo($id)
    {
        $this->action($id, function ($id) {
            $user = new User (
                $_POST['name'],
                new EmployeeInfo($_POST['profession'], $_POST['address'], $_POST['phone'])
            );
            $this->repo->updateInfo($id, $user);
        }, 'edit');
    }

    public function editStatus($id)
    {
        $this->action($id, function ($id) {
            $user = new User (
                '',
                null,
                new WebInfo('', '', $_POST['status'], '')
            );
            $this->repo->updateStatus($id, $user);
        }, 'status');
    }

    public function editSecurity($id)
    {
        $this->action($id, function ($id) {
            $user = new User (
                '',
                null,
                new WebInfo($_POST['email'], $_POST['password'])
            );

            try {
                $this->auth->changeEmail($user->email(), function ($selector, $token){
                    $this->auth->confirmEmail($selector, $token);
                });
                $this->auth->changePasswordWithoutOldPassword($user->password());
            } catch (\Exception $e) {
                Flash::error('Ошибка!');
                echo $this->templates->render('security', ['user' => $user, 'id' => $id]);
                exit;
            }

            $this->repo->updateEmail($id, $user);
        }, 'security');
    }

    public function editImage($id)
    {
        // call action with image editing functionality
    }

    private function action($id, $action, $page)
    {

        $this->redirectIfForbidden($id);

        if (!empty($_POST)) {

            $action($id);

            header('Location: /');
            exit;
        }

        $user = $this->repo->getUserById($id);
        echo $this->templates->render($page, ['user' => $user, 'id' => $id]);
    }
}