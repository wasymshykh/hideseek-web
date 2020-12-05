<?php

require 'config/init.php';

if (!isset($_GET['code']) || empty(normal_text($_GET['code']))) {
    go(URL.'/');
}

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

$code = $auth->get_reset_code(normal_text($_GET['code']));

if (!$code) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Invalid Code.'];
    go(URL . '/');
}

if (isset($_POST) && !empty($_POST)) {

    if (!isset($_POST['password']) || !isset($_POST['cpassword'])) {
        $error = "Invalid data";
    } else {

        $user = new User();

        $valid = $user->validate_password($_POST['password']);
        if (!$valid['status']) {
            $error = $valid['message'];
        } else {
            $password = $valid['message'];
        }

        if (!$error) {

            $valid = $user->validate_password($_POST['cpassword'], "Confirm password ");
            if (!$valid['status']) {
                $error = $valid['message'];
            } else {
                $cpassword = $valid['message'];
            }

            if (!$error) {
                if ($password != $cpassword) {
                    $error = "Passwords doesn't match";
                }
            }
        }

        if (!$error) {

            $saved = $auth->save_password($password, $code['user_id']);

            if ($saved['status']) {
                $auth->change_code_status($code['reset_code'], 'U');


                $_SESSION['status'] = ['type' => 'success', 'message' => 'Password have been saved. Login now!'];
                go(URL . '/');

            } else {
                $error = $saved['message'];
            }

        }


    }

}

require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'reset.view.php';

require LAYOUT_DIR . 'footer.view.php';



