<?php

require '../config/init.php';

if (!$logged) {
    go(URL);
}

if (!isset($_GET['team']) || !is_numeric($_GET['team']) || empty(normal_text($_GET['team']))) {
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

$team = $profile->get_team_by('team_id', normal_text($_GET['team']));

if (!$team || empty($team)) {
    $_SESSION['status'] = ['type' => 'error', 'message' => 'You do not have permission to access.'];
    go(URL.'/dashboard');
}


if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['add_game'])) {
        $result = $profile->add_game($team['team_id']);

        if ($result['status']) {
            $_SESSION['status'] = ['type' => 'success', 'message' => "Game has been added successfully! Game-ID #" . $result['message']]; 
            go(URL . '/dashboard/team?team=' . $team['team_id']);
        }

        $error = $result['message'];
    }

    if (isset($_POST['add_round']) && is_numeric($_POST['add_round']) && !empty($_POST['add_round']) ) {

        $_game = $profile->get_game_by('game_id', normal_text($_POST['add_round']));

        if ($_game && !empty($_game)) {
            $players = $profile->get_team_players($_game['team_id']);
            $rounds = $profile->get_round_by('round_game_id', $_game['game_id'], true) ?? [];

            $round_number = count($rounds) + 1;
            $result = $profile->add_round($_game['game_id'], $round_number, $players);

            if ($result['status']) {
                $_SESSION['status'] = ['type' => 'success', 'message' => $result['message']]; 
                go(URL . '/dashboard/team?team=' . $team['team_id']);
            }

            $error = "Couldn't add the round";


        } else {
            $error = "No game found!";
        }

    } 

}


$players = $profile->get_team_players($team['team_id']);

$games = $profile->get_all_games_rounds($team['team_id']);

require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'dashboard/team.view.php';

require LAYOUT_DIR . 'footer.view.php';
