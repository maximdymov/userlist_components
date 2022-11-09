<?php

namespace Model\User;

use InvalidArgumentException;

class WebInfo
{
    private $email;
    private $password;
    private $status;
    private $img;
    private $id;

    public function __construct($email = '', $password = '', $status = Status::ONLINE, $img = '', $id = '')
    {
        $this->email = $email;
        $this->status = $status;
        $this->img = $img;
        $this->password = $password;
        $this->id = $id;
    }

    public function email()
    {
        return $this->email;
    }

    public function status()
    {
        return $this->status;
    }

    public function img()
    {
        if (empty($this->img)) return '/img/demo/avatars/avatar-b.png';
        return $this->img;
    }

    public function password()
    {
        return $this->password;
    }

    public function id()
    {
        return $this->id;
    }
}