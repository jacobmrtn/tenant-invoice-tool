<?php
// helps prevent people from typing the php script URL into the search bar 
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $tenant_name = $_POST["tenant_name"];
    $tenant_address = $_POST["tenant_address"];
    $monthly_rent = $_POST["monthly_rent"];
    $rent_due_date = $_POST["rent_due_date"];
    $rental_owner = $_POST["rental_owner"];
    $owner_address = $_POST["owner_address"];
    $owner_name = $_POST["owner_name"];

        
    try {
        require_once 'dbh.inc.php';
        require_once 'tenant_save_model.inc.php';
        require_once 'tenant_save_contr.inc.php';
        require_once 'tenant_load_table_view.inc.php';
    
        //ERROR HANDLERS
        $errors = [];

        if(is_tenant_table_empty($tenant_name, $tenant_address, $monthly_rent, $rent_due_date)) {
            $errors["tenant_errors_incomplete_table"] = "Incomplete information entered. <strong>Check table</strong>";
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
                'owner_name' => $owner_name
            ];
            $_SESSION["table_data"] = $tableData;

            header("Location: ../tenants.php");
            die();
        }

        save_tenant_table($pdo, $_SESSION["user_username"], $tenant_name, $tenant_address, $monthly_rent, $rent_due_date, $rental_owner,  $owner_address, $owner_name, $_SESSION["user_id"]);

        $pdo = null;
        $stmt = null; 

        header("Location: ../tenants.php");
        display_tenant_table();

        die();

    } catch(PDOException $e) {
        die('Query Failed:' . $e->getMessage());
    }

} else {
    header("Location: ../tenants.php");
    die();
}