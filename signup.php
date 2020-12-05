<?php

require 'config/init.php';

$error = false;

if (isset($_POST) && !empty($_POST)) {

    $user = new User();

    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['c_password'])) {
        $error = "Invalid data";
    } else {

        $valid = $user->validate_name($_POST['name']);
        if ($valid['status']) {
            $name = $valid['message'];
        } else {
            $error = $valid['message'];
        }

        if (!$error) {
            $valid = $user->validate_email($_POST['email']);
            if ($valid['status']) {
                $email = $valid['message'];
            } else {
                $error = $valid['message'];
            }
        }

        if (!$error) {
            $valid = $user->validate_password($_POST['password']);
            if ($valid['status']) {
                $password = $valid['message'];
            } else {
                $error = $valid['message'];
            }
        }

        if (!$error && $password != $_POST['c_password']) {
            $error = "Passwords doesn't match.";
        }

        if (!$error) {

            $signup = $auth->signup($name, $email, $password);

            if ($signup['status']) {
                $_SESSION['status'] = ['type' => 'success', 'message' => 'Registration successful, Login now.'];
                go(URL . '/');
            }

            $error = $signup['message'];

        }

    }

    if (!$error) {
        
        $login = $auth->login($email, $password);

        if ($login['status']) {
            go(URL  . '/login');
        }
        
        $error = $login['message'];
    }

}

require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'signup.view.php';

require LAYOUT_DIR . 'footer.view.php';
