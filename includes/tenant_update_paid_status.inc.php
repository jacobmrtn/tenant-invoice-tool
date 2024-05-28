<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    // Info from API POST request 
    $post_info = json_decode(file_get_contents('php://input'), true);
    $row_id = $post_info["row_id"];
    $paid_status = $post_info["paid_status"];

        
    try {
        require_once 'dbh.inc.php';
        require_once 'tenant_update_paid_status_model.inc.php';
    
        // When php script is called via JS API then run this. 
        update_tenant_paid_status($pdo, $paid_status, $row_id);

        require_once 'config_session.inc.php';
        $pdo = null;
        $stmt = null; 

        die();

    } catch(PDOException $e) {
        die('Query Failed:' . $e->getMessage());
    }

} else {
    header("Location: ../tenants.php");
    die();
}