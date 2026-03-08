<?php

class UserValidator 
{
    public function validateCreate($data)
    {
        if(
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['username']) ||
            empty($data['password'])
        ) {
            throw new Exception('All fields are required');
        }

        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email');
        }
    }
}