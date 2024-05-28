<?php

declare(strict_types=1);

//Select everything from DB
function get_user(object $pdo, string $username) {
    $query = "SELECT * FROM users WHERE username = :username;";
    // Prevents SQL Injection
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;

}