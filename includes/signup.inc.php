<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {
        // MODEL ALWAYS COMES FIRST
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';
    
        // ERROR HANDLERS

        $errors = [];

        if(is_input_empty($username, $pwd, $email)) {
            $errors["emtpy_input"] = "Missing required fields";
        }
        if(is_email_invalid($email)) {
            $errors["invalid_email"] = "Email is invalid";
        }
        if(is_username_taken($pdo, $email)) {
            $errors["username_taken"] = "Username is already taken";
        }
        if(is_email_registered($pdo, $email)) {
            $errors["email_used"] = "An account with that email already exists";
        }

        //Grabs session config file
        require_once 'config_session.inc.php';

        //This will return true if errors are present
        if($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                'username' => $username,
                'email' => $email
            ];
            $_SESSION["signup_data"] = $signupData;

            header("Location: ../login.php");
            die();
        }

        create_user($pdo, $pwd, $username, $email);
        header("Location: ../login.php?signup=success");
        
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