<?php

class Database
{
    private $dbh;

    public function connect(): PDO
    {
        try {
            $this->dbh = new PDO(
                dsn: 'mysql:host=localhost;dbname=simple-user-api', 
                username:'root', 
                password:'secret'
            );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->dbh;
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }
}