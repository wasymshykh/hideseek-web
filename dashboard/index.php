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

$teams = $profile->get_all_teams();


if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['select_team']) && is_numeric($_POST['select_team'])) {
        go(URL . '/dashboard/team?team=' . $_POST['select_team']);
    }

}


$select2 = true;
require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'dashboard/dashboard_index.view.php';

require LAYOUT_DIR . 'footer.view.php';
