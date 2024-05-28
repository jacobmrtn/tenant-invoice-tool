<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// default lifetime is 1800 (30m in seconds)
session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => '127.0.0.1',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if(isset($_SESSION["user_id"])) {
    if(!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_logged_in();
    } else {
        $interval = 60 * 30;
        if(time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_logged_in();
        }
    }
} else {
    if(!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30;
        if(time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}


function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id_logged_in() {
    session_regenerate_id(true);

    // Create new sessionID
    // use the users ID from the DB to create the new sessionID
    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId["id"];
    session_id($sessionId);

    $_SESSION["last_regeneration"] = time();
}