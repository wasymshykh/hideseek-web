<?php

class Auth
{
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function check ()
    {
        if (!isset($_SESSION['logged']) || !isset($_SESSION['user_id'])) {
            return false;
        }
        
        $user = $this->get_user_by('user_id', $_SESSION['user_id']);
        
        if (!$user || empty($user)) {
            return false;
        }

        return $user;
    }

    public function login ($email, $password)
    {
        $user = $this->get_user_by('user_email', $email);

        if (!$user || empty($user)) {
            return $this->result(false, "User not found!");
        }

        if (!password_verify($password, $user['user_password'])) {
            return $this->result(false, "Password don't match.");
        }

        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $user['user_id'];

        return $this->result(true);
    }

    public function get_user_by ($column, $value, $multiple = false) {
        $s = $this->db->prepare("SELECT * FROM `users` WHERE `$column` = :v");
        $s->bindParam(":v", $value);
        if ($s->execute()) {
            if ($multiple) {
                return $s->fetchAll();
            }
            return $s->fetch();
        }
        return false;
    }

    public function signup ($name, $email, $password)
    {
        $user = $this->get_user_by('user_email', $email);
        if ($user && !empty($user)) {
            return $this->result(false, "Email address already exists");
        }
        $password = password_hash($password, PASSWORD_BCRYPT);

        $s = $this->db->prepare("INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `user_created`) VALUE (:n, :e, :p, :dt)");

        $s->bindParam(":n", $name);
        $s->bindParam(":e", $email);
        $s->bindParam(":p", $password);
        $current_date = current_date();
        $s->bindParam(":dt", $current_date);

        if ($s->execute()) {
            return $this->result(true);
        }
        return $this->result(false, "Could not insert data");
    }

    public function logout ()
    {
        unset($_SESSION['logged']);
        unset($_SESSION['user_id']);
    }


    private function result ($status, $message = "") 
    {
        return ['status' => $status, 'message' => $message];
    }
}

