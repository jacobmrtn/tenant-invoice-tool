<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    // Info from API POST request 
    $post_info = json_decode(file_get_contents('php://input'), true);
    $row_id = $post_info["row_id"];

        
    try {
        require_once 'dbh.inc.php';
        require_once 'tenants_delete_model.inc.php';
        require_once 'tenant_load_table_view.inc.php';
    
        // When php script is called via JS API then run this. 
        delete_tenant($pdo, $row_id);

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