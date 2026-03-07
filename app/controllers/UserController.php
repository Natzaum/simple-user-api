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

    public function index()
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

        if(!$conn) {
            return json_encode([
                'status' => false,
                'message' => 'Database connection failed',
            ]);
        }

        $data = json_decode(file_get_contents("php://input"));

        $user = new User($conn);

        $name = $data->name;
        $email = $data->email;
        $username = $data->username;

        $user->postData(
            $name,
            $email,
            $username,
        );

        return json_encode([
            'name: ' => $name,
            'email: ' => $email,
            'username: ' => $username,
        ]);
    }
}