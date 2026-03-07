<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../../models/User.php';

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

        $user = new User($conn);
        
        return json_encode($user->fetchAll());
    }

    public function create()
    {
        $conn = $this->dbh->connect();

        $data = json_decode(file_get_contents("php://input"));

        $name = $data->name;
        $email = $data->email;
        $username = $data->username;

        if(!$conn) {
        return json_encode([
            'status' => false,
            'message' => 'Database connection failed',
        ]);
    }

        $sth = $conn->prepare('INSERT INTO users(name, email, username) VALUES (:name, :email, :username)');
        $sucess = $sth->execute([
            ':name' => $name,
            ':email' => $email,
            ':username' => $username,
        ]);

        if($sucess) {
            return json_encode([
                'name: ' => $name,
                'email: ' => $email,
                'username: ' => $username,
            ]);
        }
    }
}