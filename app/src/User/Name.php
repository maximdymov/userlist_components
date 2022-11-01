<?php

namespace Model\User;

use InvalidArgumentException;

class Name
{
    private $firstName;
    private $secondName;

    public function __construct($firstName = 'Новый', $secondName = 'Пользователь')
    {
        if (empty($firstName) || empty($secondName)) throw new InvalidArgumentException();
        $this->firstName = $firstName;
        $this->secondName = $secondName;
    }

    public function first()
    {
        return $this->firstName;
    }

    public function second()
    {
        return $this->secondName;
    }

    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->secondName;
    }

}