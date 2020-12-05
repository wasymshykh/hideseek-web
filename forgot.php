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

    if (isset($_POST['email'])) {

        $user = new User();
        $valid = $user->validate_email($_POST['email']);
        if (!$valid['status']) {
            $error = $valid['message'];
        } else {
            $email = $valid['message'];
        }

        if (!$error) {
            $user = $auth->get_user_by('user_email', $email);
            if (!$user || empty($user)) {
                $error = "Email address doesn't exists";
            } else {

                

            }
        }

    } else {
        $error = "Invalid data";
    }

}



require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'forgot.view.php';

require LAYOUT_DIR . 'footer.view.php';
