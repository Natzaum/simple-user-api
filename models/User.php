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
        $sth = $this->dbh->prepare('SELECT name, email, username FROM users');
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function postData($name, $email, $username)
    {
        $sth = $this->dbh->prepare('INSERT INTO users(name, email, username) VALUES (:name, :email, :username)');
        $success = $sth->execute([
            ':name' => $name,
            ':email' => $email,
            ':username' => $username,
        ]);

        return $success;
    }
}