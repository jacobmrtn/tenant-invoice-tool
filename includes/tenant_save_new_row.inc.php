<?php
// helps prevent people from typing the php script URL into the search bar 
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
        require_once 'tenant_save_new_row.model.inc.php';
        require_once 'tenant_save_contr.inc.php';
        require_once 'tenant_load_table_view.inc.php';
    
        //ERROR HANDLERS
        $errors = [];

        if(is_tenant_table_empty($tenant_name, $tenant_address, $monthly_rent, $rent_due_date )) {
            $errors["tenant_errors_incomplete_table"] = "Incomplete information entered. Check required fields";
        }

        //Grabs session config file so we can use $_SESSION vars
        require_once 'config_session.inc.php';
        
        //If errors kill script. 
        if($errors) {
            $_SESSION["tenant_errors_incomplete_table"] = $errors;

            $tableData = [
                'tenant_name' => $tenant_name,
                'tenant_address' => $tenant_address,
                'monthly_rent' => $monthly_rent,
                'rent_due_date' => $rent_due_date,
                'rental_owner' => $rental_owner,
                'owner_address' => $owner_address,
                'owner_name' => $owner_name,
            ];
            $_SESSION["table_data"] = $tableData;

            header("Location: ../tenants.php");
            die();
        }

        save_tenant_new_row($pdo, $_SESSION["user_username"], $tenant_name, $tenant_address, $monthly_rent, $rent_due_date, $rental_owner,  $owner_address, $owner_name, $_SESSION["user_id"]);
        display_tenant_table();
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