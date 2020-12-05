<?php

require 'config/init.php';

$error = false;
$success = false;

if (isset($_SESSION['status']) && !empty($_SESSION['status'])) {
    if ($_SESSION['status']['type'] === 'success') {
        $success = $_SESSION['status']['message'];
    } else if ($_SESSION['status']['type'] === 'error') {
        $error = $_SESSION['status']['message'];
    }
    unset($_SESSION['status']);
}


if (isset($_POST) && !empty($_POST)) {

    $user = new User();
    if (isset($_POST['email'])) {
        $valid = $user->validate_email($_POST['email']);
        if ($valid['status']) {
            $email = $valid['message'];
        } else {
            $error = $valid['message'];
        }
    }
    if (!$error && isset($_POST['password'])) {
        $valid = $user->validate_password($_POST['password']);
        if ($valid['status']) {
            $password = $valid['message'];
        } else {
            $error = $valid['message'];
        }
    }

    if (!$error) {
        
        $login = $auth->login($email, $password);

        if ($login['status']) {
            go(URL  . '/dashboard');
        }
        
        $error = $login['message'];
    }

}

require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'home.view.php';

require LAYOUT_DIR . 'footer.view.php';
