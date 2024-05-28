<?php

require_once 'config_session.inc.php';


if(isset($_SESSION["session_lifetime"]) && time() > $_SESSION["session_lifetime"]) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    die();
}