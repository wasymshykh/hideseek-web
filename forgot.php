<?php

require 'config/init.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

                $reset_code = $auth->reset_request($user['user_id']);

                if (!$reset_code['status']) {

                    $error = $reset_code['message'];

                } else {

                    require 'vendor/autoload.php';
    
                    $mail = new PHPMailer(true);
    
                    try {
                        //Server settings
                        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.mailtrap.io';
                        $mail->SMTPAuth = true;
                        $mail->Username = '37b242f534a32f';
                        $mail->Password = '960c39a4654e9d';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
    
                        //Recipients
                        $mail->setFrom('from@example.com', 'Mailer');
                        $mail->addAddress($user['user_email'], $user['user_name']);
    
                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset Request';
                        $reset_url = URL.'/reset?code='.$reset_code['message'];
                        $mail->Body = 'Hello! <br> Your password can be reset at <a href="'.$reset_url.'">'.$reset_url.'</a>';
    
                        $mail->send();
                        
                        $success = "Email has been sent!";
    
                    } catch (Exception $e) {
                        $error = "Email could not be sent. Mailer Error.";
                        if (PROJECT_MODE === 'development') {
                            $error .= " {$mail->ErrorInfo}";
                        }
                    }
                }
            }
        }
    } else {
        $error = "Invalid data";
    }
}



require LAYOUT_DIR . 'header.view.php';

require PAGE_DIR . 'forgot.view.php';

require LAYOUT_DIR . 'footer.view.php';
