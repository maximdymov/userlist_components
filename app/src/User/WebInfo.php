<?php

namespace Model\User;

use InvalidArgumentException;

class WebInfo
{
    private $email;
    private $password;
    private $status;
    private $img;

    public function __construct($email, $password = '', string $status = Status::ONLINE, $img = '')
    {
        $this->email = $email;
        $this->status = $status;
        $this->img = $img;
        $this->password = $password;
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
        return $this->img;
    }

    public function password() {
        return $this->password;
    }
}