<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $post_info = json_decode(file_get_contents('php://input'), true);
    $tenant_name = $post_info["tenant_name"];
    $tenant_address = $post_info["tenant_address"];
    $monthly_rent = $post_info["monthly_rent"];
    $rent_due_date = $post_info["rent_due_date"];
    $rental_owner = $post_info["rental_owner"];
    $owner_address = $post_info["owner_address"];
    $owner_name = $post_info["owner_name"];


    
    try {
        require_once 'dbh.inc.php';
        require_once 'tenant_save_model.inc.php';
        require_once 'tenant_save_contr.inc.php';
        require_once 'tenant_load_table_view.inc.php';

        //Grabs session config file so we can use $_SESSION vars
        require_once 'config_session.inc.php';
        
        save_tenant_table($pdo, $_SESSION["user_username"], $tenant_name, $tenant_address, $monthly_rent, $rent_due_date, $rental_owner,  $owner_address, $owner_name, $_SESSION["user_id"]);
        
        $pdo = null;
        $stmt = null; 

        header("Location: ../tenants.php?save=success");
        display_tenant_table();

        die();

    } catch(PDOException $e) {
        die('Query Failed:' . $e->getMessage());
    }

} else {
    header("Location: ../tenants.php");
    die();
}