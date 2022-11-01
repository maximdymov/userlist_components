<?php

namespace Model\User;

use Aura\SqlQuery\Mysql\Insert;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use Exception;
use PDO;

class UserRepository
{
    private $pdo;
    private $query;
    private $tableName;

    public function __construct()
    {
        $this->tableName = 'users_info';
        $this->query = new QueryFactory('mysql');
        $this->pdo = new PDO("mysql:host=localhost;dbname=userlist", 'root', '1234');
    }

    public function getAllUsers(): array
    {
        $select = $this->query->newSelect();

        $select
            ->cols(['*'])
            ->from($this->tableName);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $users = $sth->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($users as $i => $user) {
            $result[$i] = new User(
                $user['name'],
                new EmployeeInfo($user['profession'], $user['address'], $user['phone']),
                new WebInfo($user['email'])
            );
        }

        return $result;

    }

    public function saveUser(User $user)
    {
        $insert = $this->query->newInsert();

        $insert
            ->into($this->tableName)
            ->cols([
                'name' => $user->name(),
                'profession' => $user->profession(),
                'address' => $user->address(),
                'phone' => $user->phone(),
                'email' => $user->email()
            ]);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function deleteUser()
    {

    }

    public function updateUser() {

    }

}