<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        require_once 'tenant_load_table_model.inc.php';

        // ERROR HANDLERS

        $errors = [];

        if(is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Missing required fields";
        }

        $result = get_user($pdo, $username);

        if(is_username_invalid($result)) {
            $errors["login_invalid"] = "Invalid login info";
        }

        //This checks if the password is invalid. We want to verity the username is valid first (!is_username_invalid)
        if(!is_username_invalid($result) && is_password_invalid($pwd, $result["pwd"])) {
            $errors["login_invalid"] = "Invalid login info";
        }

        //Grabs session config file
        require_once 'config_session.inc.php';

        //This will return true if errors are present
        if($errors) {
            $_SESSION["errors_login"] = $errors;

            header("Location: ../login.php");
            die();
        }
        
        // Create new sessionID
        // use the users ID from the DB to create the new sessionID
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);
        
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["last_regeneration"] = time();

        // set session timeout to 30 min
        $_SESSION["session_lifetime"] = time() + 60 * 1;

        // Create and store the data associated with the user_id
        $user_tenant_table = load_tenant_table($pdo, $_SESSION["user_id"]);
        $_SESSION["user_tenant_table"] = $user_tenant_table;


        //Send user to tenants.php page after a successful login
        header("Location: ../tenants.php");

        $pdo = null;
        $stm = null;
        die();

    } catch(PDOException $e) {
        die('Query failed:'. $e->getMessage());
    }

} else {
    header("Location: ../login.php");
    die();
}