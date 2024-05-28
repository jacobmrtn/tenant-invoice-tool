<?php

declare(strict_types=1);

function is_input_empty(string $username, string $pwd) {
    if(empty($username) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function is_username_invalid(bool | array $result) {
    if(!$result) {
        return true;
    } else {
        return false;
    }
}

//check if password user entered is FALSE 
function is_password_invalid(string $pwd, string $hashedPwd) {
    if(!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }

}