<?php

class DB
{
    /*
        Setting values from system constants
    */
    private $host = DB_HOST;
    private $database = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    public function credentials ($host, $database, $username, $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        $dsn = 'mysql:host=' . $this->host . '; dbname=' . $this->database;
        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
        } catch(Exception $e) {
            if (PROJECT_MODE === 'development') {
                echo $e;
            } else {
                die('E.01: Database Connection Failure');
            }
            return false;
        }
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
