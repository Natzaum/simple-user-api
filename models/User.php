<?php

class User 
{
    private $dbh;

    public function __construct($db)
    {
        $this->dbh = $db;
    }

    public function fetchAll()
    {
        $sth = $this->dbh->prepare('SELECT id, name, email, username FROM users');
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        if($sth->rowCount() === 0){
            throw new Exception('No users in the database');
        }

        return $result;
    }

    public function postData($name, $email, $username)
    {
        $sth = $this->dbh->prepare(
            'INSERT INTO users
            SET name = :name, email = :email, username = :username'
        );

        $sth->execute([
            ':name' => $name,
            ':email' => $email,
            ':username' => $username,
        ]);

        return true;
    }

    public function updateData($id, $name, $email, $username)
    {
        $sth = $this->dbh->prepare(
            'UPDATE users 
            SET name = :name, email = :email, username = :username 
            WHERE id = :id'
        );

        $sth->execute([
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':username' => $username,
        ]);

        if($sth->rowCount() === 0){
            throw new Exception('User not found');
        }

        return true;
    }

    public function deleteData($id)
    {
        $sth = $this->dbh->prepare(
            'DELETE FROM users WHERE id = :id'
        );

        $sth->execute([
            ':id' => $id,
        ]);

        if($sth->rowCount() === 0){
            throw new Exception('User not found');
        }

        return true;
    }
}