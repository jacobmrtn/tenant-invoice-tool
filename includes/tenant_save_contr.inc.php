<?php

declare(strict_types=1);

// Check if required inputs in the tenant table are empty. return TRUE if so.
function is_tenant_table_empty(string $tenant_name, string $tenant_address, $monthly_rent,  string $rent_due_date) {
    if(empty($tenant_name) || empty($tenant_address) || empty($monthly_rent) || empty($rent_due_date)) {
        return true;
    } else {
        return false;
    }
}