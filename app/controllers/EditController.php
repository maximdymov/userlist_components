<?php

namespace App\Controllers;

use Model\ImageLoader;
use Model\User\EmployeeInfo;
use Model\User\User;
use Model\User\UserRepository;
use Model\User\WebInfo;
use Tamtamchik\SimpleFlash\Flash;

class EditController extends AbstractController
{

    public function editInfo($id)
    {
        $this->editAction($id, 'edit', function ($id) {
            $user = new User (
                $_POST['name'],
                new EmployeeInfo($_POST['profession'], $_POST['address'], $_POST['phone'])
            );
            $this->repo->updateInfo($id, $user);
        });
    }

    public function editStatus($id)
    {
        $this->editAction($id, 'status', function ($id) {
            $user = new User (
                '',
                null,
                new WebInfo('', '', $_POST['status'], '')
            );
            $this->repo->updateStatus($id, $user);
        });
    }

    public function editSecurity($id)
    {
        $this->editAction($id, 'security', function ($id) {
            $user = new User (
                '',
                null,
                new WebInfo($_POST['email'], $_POST['password'])
            );

            try {
                $this->auth->changeEmail($user->email(), function ($selector, $token) {
                    $this->auth->confirmEmail($selector, $token);
                });
                $this->auth->changePasswordWithoutOldPassword($user->password());
            } catch (\Exception $e) {

            }

            $this->repo->updateEmail($id, $user);
        });
    }

    public function editImage($id)
    {
        $this->editAction($id, 'media', function ($id) {

            $img = ImageLoader::loadImage($_FILES['img']);

            $user = new User(
                '',
                null,
                new WebInfo('', '', '', $img));

            $this->repo->updateImg($id, $user);
        });
    }

    private function editAction($id, $page, $action)
    {
        $this->action(function () use ($page, $action, $id) {
            $this->redirectIfForbidden($id);

            if (!empty($_POST) || !empty($_FILES)) {

                $action($id);

                header('Location: /');
                exit;
            }

            $this->action(function () use ($page, $id) {
                $user = $this->repo->getUserById($id);
                echo $this->templates->render($page, ['user' => $user, 'id' => $id]);
            });
        });
    }

    protected function showError(\Exception $e)
    {
        Flash::error('Ошибка!');
        exit;
    }
}