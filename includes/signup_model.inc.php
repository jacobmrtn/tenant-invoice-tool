<?php

declare(strict_types=1);

// Search the DB for username
function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username;";
    // Prevents SQL Injection
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Search the DB for email
function get_email(object $pdo, string $email) {
    $query = "SELECT username FROM users WHERE email = :email;";
    // Prevents SQL Injection
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Add user to DB
function set_user(object $pdo, string $pwd, string $username, string $email) {
    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";
    
    // Hashing the pwd so nobody can read it in the DB
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    // Prevents SQL Injection
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
}
