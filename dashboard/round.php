<?php

require '../config/init.php';

if (!$logged) {
    go(URL);
}

if (!isset($_GET['round']) || !is_numeric($_GET['round']) || empty(normal_text($_GET['round']))) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'Invalid url paramters'];
    go(URL.'/dashboard');
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

$round = $profile->get_round_by('round_id', normal_text($_GET['round']));

if (!$round || empty($round)) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'You do not have permission to access.'];
    go(URL.'/dashboard');
}

$results = $profile->get_result_by('round_id', $round['round_id'], true);


if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['found']) && is_numeric($_POST['found']) && !empty(normal_text($_POST['found']))) {

        $_result = $profile->player_found(normal_text($_POST['found']), $results);

        if ($_result['status']) {
            $_SESSION['status'] = ['type' => 'success', 'message' => $_result['message']]; 
            go(URL . '/dashboard/round?round=' . $round['round_id']);
        }

        $error = $_result['message'];

    }

}


require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'dashboard/round.view.php';

require LAYOUT_DIR . 'footer.view.php';


