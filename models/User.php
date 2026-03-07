<?php

class User 
{
    private $dbh;

    private $name;
    private $email;
    private $username;

    public function __construct($db)
    {
        $this->dbh = $db;
    }

    public function fetchAll()
    {
        $sth = $this->dbh->prepare('SELECT * FROM users');
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}