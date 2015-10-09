<?php

function defaultTodoPdo() {    
    if (isset($_ENV['DB_DSN'])) {
        $db = $_ENV['DB_DSN'];
        $username = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
    }
    else {
        $db = getenv('DB_DSN');
        $username = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');
    }


    return new PDO($db, $username, $pass);
}