<?php

declare(strict_types=1);

function save_tenant_table(object $pdo, string $username, string $tenant_name, string $tenant_address, string $monthly_rent, string $rent_due_date, string $rental_owner, string $owner_address, string $owner_name, string $users_id) {
    $query = "INSERT INTO tenants (username, tenant_name, tenant_address, monthly_rent, rent_due_date, rental_owner, owner_address, owner_name, users_id) VALUES (:username, :tenant_name, :tenant_address, :monthly_rent, :rent_due_date, :rental_owner, :owner_address, :owner_name, :users_id);";
    // Prevent SQL Injections
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":tenant_name", $tenant_name);
    $stmt->bindParam(":tenant_address", $tenant_address);
    $stmt->bindParam(":monthly_rent", $monthly_rent);
    $stmt->bindParam(":rent_due_date", $rent_due_date);
    $stmt->bindParam(":rental_owner", $rental_owner);
    $stmt->bindParam(":owner_address", $owner_address);
    $stmt->bindParam(":owner_name", $owner_name);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
}

function update_tenant_table(object $pdo, int $row_id, string $username, string $tenant_name, string $tenant_address, string $monthly_rent, string $rent_due_date, string $rental_owner, string $owner_address, string $owner_name, string $users_id) {
    $query = "UPDATE tenants SET username = :username, tenant_name = :tenant_name, tenant_address = :tenant_address, monthly_rent = :monthly_rent, rent_due_date = :rent_due_date, rental_owner = :rental_owner, owner_address = :owner_address, owner_name = :owner_name WHERE id = :row_id;";
    // Prevent SQL Injections 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":row_id", $row_id);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":tenant_name", $tenant_name);
    $stmt->bindParam(":tenant_address", $tenant_address);
    $stmt->bindParam(":monthly_rent", $monthly_rent);
    $stmt->bindParam(":rent_due_date", $rent_due_date);
    $stmt->bindParam(":rental_owner", $rental_owner);
    $stmt->bindParam(":owner_address", $owner_address);
    $stmt->bindParam(":owner_name", $owner_name);
    $stmt->execute();
}