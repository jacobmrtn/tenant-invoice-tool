<?php

declare(strict_types=1);

function signup_input() {
    //Check to see if user imputed a user name AND the username is not taken
    if(isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username" value="'. $_SESSION["signup_data"]["username"] .'">';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    echo '<input type="password" name="pwd" placeholder="Password">';


    //Check to see if user imputed an email AND the email IS NOT used and IS NOT invalid
    if(isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["email_invalid"])) {
        echo '<input type="text" name="email" placeholder="Email" value="'. $_SESSION["signup_data"]["email"] .'">';
    } else {
        echo '<input type="text" name="email" placeholder="Email">';
    }

}

function check_signup_errors() {
    if(isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        echo "<br>";

        foreach($errors as $error) {
            echo '<p class="form-error">'. $error . '</p>';
        }

        unset( $_SESSION['errors_signup']);

    } else if (isset($_GET["signup"]) && $_GET["signup"] === 'success') {
        echo '<br>';
        echo '<p class="form-success">Signup success!</p>';
    }
}
