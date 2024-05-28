<?php 

if($_SERVER["REQUEST_METHOD"] === "POST") {
    try {

        require_once 'dbh.inc.php';
        require_once 'tenant_load_table_model.inc.php';

        require_once 'config_session.inc.php';

    } catch(PDOException $e) {
        die('Query failed' . $e->getMessage());
    }
} else {
    header("Location: ../login.php?error");
    die();
}