<?php

use josegonzalez\Dotenv\Loader as Dotenv;

function loadDotEnv($dir = __DIR__) {
    /**
     * alternatively, Dotenv::load(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
     */
    Dotenv::load([
        'filepath' => dirname($dir) . DIRECTORY_SEPARATOR . '.env',
        'toEnv' => true,
    ]);
}