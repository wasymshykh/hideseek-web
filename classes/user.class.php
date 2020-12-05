<?php

class User
{
    
    public function validate_name ($name)
    {
        if (!is_string($name) || empty(normal_text($name))) {
            return $this->result(false, "Name cannot be empty!");
        }
        return $this->result(true, normal_text($name));
    }

    public function validate_email ($email)
    {
        if (!is_string($email) || empty(normal_text($email))) {
            return $this->result(false, "Email cannot be empty!");
        }
        return $this->result(true, normal_text($email));
    }

    public function validate_password ($password, $password_type = "password")
    {
        if (!is_string($password) || empty(normal_text($password))) {
            return $this->result(false, "$password_type cannot be empty!");
        }
        if (strlen($password) < 4) {
            return $this->result(false, "$password_type must be 4 characters long!");
        }
        return $this->result(true, normal_text($password));
    }

    private function result($status, $message)
    {
        return ['status' => $status, 'message' => $message];
    }

}

