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
        try {
            $conn = $this->dbh->connect();
            $user = new User($conn);
        
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
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $conn = $this->dbh->connect();

            $user = new User($conn);
            $validator = new UserValidator();

            $name = trim($data['name']);
            $email = str_replace(' ', '', trim($data['email']));
            $username = str_replace(' ', '', trim($data['username']));
            $password = trim($data['password']);

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


    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $conn = $this->dbh->connect();
            $user = new User($conn);
            $validator = new UserValidator();

            $name = trim($data['name']);
            $email = str_replace(' ', '', trim($data['email']));
            $username = str_replace(' ', '', trim($data['username']));
            $password = trim($data['password']);

            $validator->validateCreate($data);

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
            http_response_code(400);

            return json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function delete($id)
    {
        try {
            $conn = $this->dbh->connect();
            $user = new User($conn);

            if($id === null) {
                throw new Exception('User ID is required');
            }

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