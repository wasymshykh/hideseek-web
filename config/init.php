<?php
    session_start();

    // Main project directory
    define('DIR', dirname(__DIR__).'/');

    define('URL', "https://hideseek.test");


    // Either: development/production
    define('PROJECT_MODE', 'development'); 
    
    if (PROJECT_MODE !== 'development') {
        error_reporting(0);
    } else {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    define('LAYOUT_DIR', dirname(__DIR__).'/views/layout/');
    define('PAGE_DIR', dirname(__DIR__).'/views/');

    // Database details
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'hideseek');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');

    // Timezone setting
    define('TIMEZONE', 'Asia/Karachi');
    date_default_timezone_set(TIMEZONE);

    define('SECRET', 'test');
    define('SESSION_EXPIRE_TIME', 3600);

    // Auto load classes
    include DIR . 'config/auto_loader.php';

    // Functions
    include DIR . 'includes/functions.php';

    // Get db handle
    $db = (new DB())->connect();

    // Get auth 
    $auth = new Auth($db);

    $logged = $auth->check();

