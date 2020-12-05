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

    public function save_profile($name, $email, $user_id)
    {
        $s = $this->db->prepare("UPDATE `users` SET `user_email` = :e, `user_name` = :n WHERE `user_id` = :i");

        $s->bindParam(":e", $email);
        $s->bindParam(":n", $name);
        $s->bindParam(":i", $user_id);

        if ($s->execute()) {
            return $this->result(true);
        }
        return $this->result(false, "Could not update data");
    }

    public function save_password($password, $user_id)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        
        $s = $this->db->prepare("UPDATE `users` SET `user_password` = :p WHERE `user_id` = :i");

        $s->bindParam(":p", $password);
        $s->bindParam(":i", $user_id);

        if ($s->execute()) {
            return $this->result(true);
        }
        return $this->result(false, "Could not update data");
    }

    public function reset_request($user_id)
    {
        $unique_code = $this->generateRandomString();

        $s = $this->db->prepare("INSERT INTO `reset_requests` (`reset_user_id`, `reset_code`, `reset_created`) VALUE (:i, :c, :dt)");

        $s->bindParam(":i", $user_id);
        $s->bindParam(":c", $unique_code);

        $current_date = current_date();
        $s->bindParam(":dt", $current_date);

        if ($s->execute()) {
            return $this->result(true, $unique_code);
        }
        return $this->result(false, "Could not process the request");
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function change_code_status($code, $status)
    {
        $s = $this->db->prepare("UPDATE `reset_requests` SET `reset_status` = :s WHERE `reset_code` = :c");
        $s->bindParam(":s", $status);
        $s->bindParam(":c", $code);
        $s->execute();
    }

    public function get_reset_code($code)
    {
        $s = $this->db->prepare("SELECT * FROM `reset_requests` WHERE `reset_code` = :c AND `reset_status` = 'A'");
        $s->bindParam(":c", $code);
        if ($s->execute()) {
            return $s->fetch();
        }
        return false;
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

