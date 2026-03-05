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

    public function query(string $sql): bool | PDOStatement
    {   
        if(!$this->dbh) {
            echo 'Failed to connect';
        }

        $result = $this->dbh->query(query: $sql);
        return $result;
    }
}