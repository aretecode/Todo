<?php

// to remove excess redirect stuff
function modifyServerSuperGlobalVariable($dir = __DIR__) {
    if (!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['REDIRECT_URL'])) 
        return false;


    // change back slash to forward slash - only on windows
    $__DIR__ = str_replace('\\', '/', $dir);

    // take the (DOCUMENT_ROOT) & the (current folder out) of (__DIR__)
    $remove = str_replace([$_SERVER['DOCUMENT_ROOT']], "", $__DIR__);
    $remove = strtolower($remove);

    // take the (DOCUMENT_ROOT) out of the (REQUEST_URI) & (REDIRECT_URL)
    $_SERVER['REQUEST_URI'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['REQUEST_URI']);
    $_SERVER['REDIRECT_URL'] = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['REDIRECT_URL']);
   
    // make them lowercase
    $_SERVER['REQUEST_URI'] = strtolower($_SERVER['REQUEST_URI']);
    $_SERVER['REDIRECT_URL'] = strtolower($_SERVER['REDIRECT_URL']);

    // replace part of the directory with nothing
    $_SERVER['REQUEST_URI'] = str_replace($remove, "", $_SERVER['REQUEST_URI']);
    $_SERVER['REDIRECT_URL'] = str_replace($remove, "", $_SERVER['REDIRECT_URL']);  
}
