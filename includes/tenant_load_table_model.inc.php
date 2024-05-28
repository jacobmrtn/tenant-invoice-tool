<?php

declare(strict_types=1);

function load_tenant_table(object $pdo, int $users_id) {
    $query = "SELECT * FROM tenants WHERE users_id = :users_id;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
