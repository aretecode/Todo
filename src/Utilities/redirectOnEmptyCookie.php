<?php

function redirectOnEmptyCookie() {
    /**
     * need to check if auth credentials are set differently...
     * if cookie is empty, include (or could redirect) login.php 
     *
     * or could do `include 'login.php'; die();`
     */
    if (empty($_COOKIE)) {
        redirectRelative('login.php');
        return;
    }
}
