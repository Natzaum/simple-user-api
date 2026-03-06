<?php

class Database
{
    private $dbh;

    public function connect(): PDO
    {
        $this->dbh = new PDO(
            dsn: 'mysql:host=localhost;dbname=simple-user-api', 
            username:'root', 
            password:'secret'
        );

        return $this->dbh;
    }
}