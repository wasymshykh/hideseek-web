<?php

require '../config/init.php';

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


if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['name']) && isset($_POST['team_members'])) {

     
        if (empty($_POST['name']) && (!is_string($_POST['name']) || empty(normal_text($_POST['name'])))) {
            $error = "Team name cannot be empty";
        }

        if (!$error && (!is_array($_POST['team_members']) || empty($_POST['team_members']))) {
            $error = "Team members cannot be empty";
        }

        if (!$error) {
            $name = normal_text($_POST['name']);

            $result = $profile->add_team($name, $_POST['team_members']);

            if ($result['status']) {
                $_SESSION['status'] = ['type' => 'success', 'message' => $result['message']]; 
                go(URL . '/dashboard/create_team');
            }

            $error = $result['message'];

        }
        

    } else {
        $error = "Invalid data";
    }

}

require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'dashboard/create_team.view.php';

require LAYOUT_DIR . 'footer.view.php';


