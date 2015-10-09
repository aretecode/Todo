<?php

function startSession() {
    /**
     * only for the Auth
     */
    if (session_status() !== PHP_SESSION_ACTIVE) 
        session_start();
}
