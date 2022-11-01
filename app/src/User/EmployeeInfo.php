<?php

namespace Model\User;

use InvalidArgumentException;

class EmployeeInfo
{
    private $profession;
    private $address;
    private $phone;

    public function __construct($profession = 'Worker', $address = 'Unknown', $phone = '')
    {
        $this->profession = $profession;
        $this->address = $address;
        $this->phone = $phone;
    }

    public function profession()
    {
        return $this->profession;
    }

    public function address()
    {
        return $this->address;
    }

    public function phone()
    {
        return $this->phone;
    }
}