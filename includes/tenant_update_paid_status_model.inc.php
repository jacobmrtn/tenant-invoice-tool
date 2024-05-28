<?php 

declare(strict_types=1);

function update_tenant_paid_status(object $pdo, bool $paid_status, int $row_id) {
    $query = "UPDATE tenants SET rent_paid = :paid_status WHERE id = :row_id";
    // Prevent SQL Injections   
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":paid_status", $paid_status);
    $stmt->bindParam(":row_id", $row_id);
    $stmt->execute();

}