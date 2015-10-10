<?php

function defaultTodoPdo() {    
    if (isset($_ENV['DB_DSN'])) {
        $db = $_ENV['DB_DSN'];
        $username = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
    }
    elseif (getenv('DB_DSN')) {
        $db = getenv('DB_DSN');
        $username = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');
    }    
    else {
        $db = 'mysql:dbname=auraauthentication;host=127.0.0.1';
        $username = 'root';
        $pass = "";
    }

    return new PDO($db, $username, $pass);
}