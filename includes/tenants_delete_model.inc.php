<?php 

declare(strict_types=1);

function delete_tenant(object $pdo, int $row_id) {
    $query = "DELETE FROM tenants WHERE tenants.ID = :row_id";
    // Prevent SQL Injections   
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":row_id", $row_id);
    $stmt->execute();

}