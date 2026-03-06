<?php

require_once __DIR__ . '/../config/Database.php';

class UserController
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = new Database();
    }
    
    public function index(): string
    {
        $conn = $this->dbh->connect();

        if(!$conn) {
            return json_encode([
                'status' => false,
                'message' => 'Database connection failed',
            ]);
        }

        $sth = $conn->prepare('SELECT * FROM users');
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);
    }
}