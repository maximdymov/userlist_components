<?php
namespace Model\User;

class User
{
    private $name;
    private EmployeeInfo $employeeInfo;
    private WebInfo $webInfo;

    public function __construct($name, EmployeeInfo $employeeInfo, WebInfo $webInfo)
    {
        if (empty($name)) $this->name = 'Новый пользователь';
        else $this->name = $name;

        $this->employeeInfo = $employeeInfo;
        $this->webInfo = $webInfo;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function phone() {
        return $this->employeeInfo->phone();
    }

    public function address() {
        return $this->employeeInfo->address();
    }

    public function profession() {
        return $this->employeeInfo->profession();
    }

    public function email()
    {
        return $this->webInfo->email();
    }

    public function status()
    {
        return $this->webInfo->status();
    }

    public function img() {
        return $this->webInfo->img();
    }

    public function password() {
        return $this->webInfo->password();
    }

}

