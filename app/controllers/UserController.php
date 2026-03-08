<?php

require_once __DIR__ . '/../validators/UserValidator.php';
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
        
        try {
            return json_encode($user->fetchAll());
        } catch(Exception $e) {
            http_response_code(404);

            return json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
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

        $data = json_decode(file_get_contents("php://input"), true);

        $user = new User($conn);
        $validator = new UserValidator();

        $name = trim($data['name']);
        $email = str_replace(' ', '', trim($data['email']));
        $username = str_replace(' ', '', trim($data['username']));
        $password = trim($data['password']);

        try{
            $validator->validateCreate($data);

            if($user->emailExists($email)){
                throw new Exception('Email already exists');
            }

            $user->postData(
                $name,
                $email,
                $username,
                $password,
            );

            return json_encode([
                'status' => true,
                'message' => 'User created successfully',
                'name' => $name,
                'email' => $email,
                'username' => $username,
            ]);
        } catch (Exception $e) {
            http_response_code(400);

            return json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function update()
    {
        $conn = $this->dbh->connect();

        if(!$conn) {
            return json_encode([
                'status' => false,
                'message' => 'Database connection failed',
            ]);
        }

        $data = json_decode(file_get_contents("php://input"), true);

        $user = new User($conn);

        $id = $data['id'];
        $name = trim($data['name']);
        $email = str_replace(' ', '', trim($data['email']));
        $username = str_replace(' ', '', trim($data['username']));
        $password = trim($data['password']);

        if(!$id === null || !$name || !$email || !$username || !$password) {
            http_response_code(400);

            return json_encode([
                'status' => false,
                'message' => 'All fields are required'
            ]);
        }

        try{
            $user->updateData(
                $id,
                $name,
                $email,
                $username,
                $password,
            );

            return json_encode([
                'status' => true,
                'message' => 'User updated successfully',
                'name' => $name,
                'email' => $email,
                'username' => $username,
            ]);
        } catch (Exception $e) {
            http_response_code(404);

            return json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function delete()
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

        $id = $data->id;

        try {
            $user->deleteData(
                $id,
            );

            return json_encode([
                'status' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch(Exception $e) {
            http_response_code(404);

            return json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}