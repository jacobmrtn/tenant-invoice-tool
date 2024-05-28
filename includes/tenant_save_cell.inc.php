<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    // Info from API POST request 
    $post_info = json_decode(file_get_contents('php://input'), true);
    $row_id = $post_info["row_id"];
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
    
        //ERROR HANDLERS
        $errors = [];

        if(is_tenant_table_empty($tenant_name, $tenant_address, $monthly_rent, $rent_due_date)) {
            $errors["tenant_errors_incomplete_table"] = "Incomplete information entered";
        }

        //Grabs session config file so we can use $_SESSION vars
        require_once 'config_session.inc.php';
        
        //If errors kill script. 
        if($errors) {
            $_SESSION["tenant_errors_incomplete_table"] = $errors;
            header("Location: /index.php");
            die();
        }

        // When php script is called via JS API then run this. 
        update_tenant_table($pdo, $row_id, $_SESSION["user_username"], $tenant_name, $tenant_address, $monthly_rent, $rent_due_date, $rental_owner,  $owner_address, $owner_name, $_SESSION["user_id"]);
        display_tenant_table();
        $pdo = null;
        $stmt = null; 

        header("Location: ../tenants.php?save=success");

        die();

    } catch(PDOException $e) {
        die('Query Failed:' . $e->getMessage());
    }

} else {
    header("Location: ../tenants.php");
    die();
}