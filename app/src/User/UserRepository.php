<?php

namespace Model\User;

use Aura\SqlQuery\Mysql\Insert;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Exception;
use PDO;

class UserRepository
{
    private $pdo;
    private $query;
    private $tableName;

    public function __construct(QueryFactory $queryFactory, PDO $pdo)
    {
        $this->tableName = 'users_info';
        $this->query = $queryFactory;
        $this->pdo = $pdo;
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
                new WebInfo($user['email'], '', $user['status'], $user['img'], $user['id'])
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
                'email' => $user->email(),
                'img' => $user->img(),
                'status' => $user->status()
            ]);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function deleteUser($id)
    {
        $delete = $this->query->newDelete();

        $delete
            ->from($this->tableName)
            ->where("id = :id")
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

    public function updateInfo($id, User $user)
    {
        $this->update($id, $user,
            [
                'profession' => $user->profession(),
                'address' => $user->address(),
                'phone' => $user->phone(),
                'name' => $user->name()
            ]);
    }

    public function updateStatus($id, User $user)
    {
        $this->update($id, $user,
            [
                'status' => $user->status()
            ]);
    }

    public function updateEmail($id, User $user)
    {
        $this->update($id, $user,
            [
                'email' => $user->email()
            ]);
    }

    public function getUserById($id): User
    {
        $select = $this->query->newSelect();

        $select
            ->cols(['*'])
            ->from($this->tableName)
            ->where("id = :id")
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        if ($user == false) throw new Exception();
        return new User(
            $user['name'],
            new EmployeeInfo($user['profession'], $user['address'], $user['phone']),
            new WebInfo($user['email'], '', $user['status'], $user['img'], $user['id'])
        );
    }

    public function updateImg($id, User $user)
    {
        $this->update($id, $user, [
            'img' => $user->img()
        ]);
    }

    private function update($id, User $user, array $cols)
    {

        $update = $this->query->newUpdate();

        $update
            ->table($this->tableName)
            ->cols($cols)
            ->where("id = :id")
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }


}