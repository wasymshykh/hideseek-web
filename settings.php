<?php

require 'config/init.php';

if (!$logged) {
    go(URL);
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

$profile = new Profile($db, $logged['user_id']);

$teams = $profile->get_all_teams();


if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['profile-save'])) {

        if (isset($_POST['name']) && isset($_POST['email'])) {
            
            $user = new User();
            
            $valid = $user->validate_name($_POST['name']);
            if (!$valid['status']) {
                $error = $valid['message'];
            } else {
                $name = $valid['message'];
            }

            if (!$error) {
                $valid = $user->validate_email($_POST['email']);
                if (!$valid['status']) {
                    $error = $valid['message'];
                } else {
                    $email = $valid['message'];
                }
            }

            if (!$error) {

                if ($logged['user_email'] != $email) {
                    $user = $auth->get_user_by('user_email', $email);
                    if ($user && !empty($user)) {
                        $error = "Email address already exists";
                    }
                }

                if (!$error) {
                    
                    $result = $auth->save_profile($name, $email, $logged['user_id']);

                    if ($result['status']) {
                        $_SESSION['status'] = ['type' => 'success', 'message' => 'Profile is successfully updated!'];
                        go(URL . '/settings');
                    }
        
                    $error = $result['message'];

                }

            }

        } else {
            $error = "Invalid data";
        }

    }

    if (isset($_POST['security-save'])) {
        if (isset($_POST['new_password']) && isset($_POST['newc_password']) && isset($_POST['password'])) {

            $user = new User();

            $valid = $user->validate_password($_POST['new_password'], "New password");
            if (!$valid['status']) {
                $error = $valid['message'];
            } else {
                $new_password = $valid['message'];
            }

            if (!$error) {
                $valid = $user->validate_password($_POST['newc_password'], "New password confirm");
                if (!$valid['status']) {
                    $error = $valid['message'];
                } else {
                    $newc_password = $valid['message'];
                }
            }

            if (!$error) {
                $valid = $user->validate_password($_POST['password'], "Current Password");
                if (!$valid['status']) {
                    $error = $valid['message'];
                } else {
                    $password = $valid['message'];
                }
            }

            if (!$error && $new_password !== $newc_password) {
                $error = "New passwords doesn't match";
            }

            if (!$error && !password_verify($password, $logged['user_password'])) {
                $error = "You have provided invalid current password";
            }

            if (!$error) {

                $result = $auth->save_password ($new_password, $logged['user_id']);

                if ($result['status']) {
                    $_SESSION['status'] = ['type' => 'success', 'message' => 'Profile is successfully updated!'];
                    go(URL . '/settings');
                }
    
                $error = $result['message'];

            }



        } else {
            $error = "Invalid data";
        }
    }

}

require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'settings.view.php';

require LAYOUT_DIR . 'footer.view.php';

