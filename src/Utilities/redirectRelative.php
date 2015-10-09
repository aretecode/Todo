<?php

function redirectRelative($file) {
    if (!isset($_SERVER['HTTP_HOST'])) 
        return 'tried to redirect to `'.$file.'` but `HTTP_HOST` was not set' . PHP_EOL;

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header('Location: http://'.$host.$uri.'/'.$file);
}
