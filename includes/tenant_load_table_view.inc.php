<?php

declare(strict_types=1);

require_once 'dbh.inc.php';
require_once 'tenant_load_table_model.inc.php';

require_once 'config_session.inc.php';


if(!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    die();
}

$user_tenant_table = load_tenant_table($pdo, $_SESSION["user_id"]);
$_SESSION["user_tenant_table"] = $user_tenant_table;

function display_tenant_table() {
    if(isset($_SESSION["user_tenant_table"])) {
        $result = $_SESSION['user_tenant_table'];

        echo "<br>";
        foreach($result as $row) {
            echo '<tr id="' . $row["id"] . '">';
            foreach($row as $key => $value) {
            
                // Remove the "_" from $key, then uppercase first letter of each word
                $placeholder = str_replace("_", " ", $key);
                $placeholder = ucwords($placeholder);

                if($key != 'id' && $key != 'username' && $key != 'users_id' && $key != 'rent_due_date' && $key != 'rent_paid') {
                    echo "<td>";
                    echo '<input onchange="updateDB(this)" contenteditable="true" type="text" data-type="table-input" name="'. $key . '" value="' . $value . '" placeholder="'. $placeholder .'">';
                    echo "</td>";
                } else if($key == "rent_due_date") {
                    $days_overdue = calculate_date_diff($value);
                    echo '' . $days_overdue;

                    if ($days_overdue > 3) {
                        echo '<td class="alert-danger">';
                        echo '<input class="alert-danger" type="date" onchange="updateDB(this)" contenteditable="true" data-type="table-input" name="'. $key . '" value="' . $value . '" placeholder="'. $placeholder .'">';
                        echo "</td>";
                    } elseif ($days_overdue > 1) {
                        echo '<td class="alert-warning">';
                        echo '<input class="alert-warning" type="date" onchange="updateDB(this)" contenteditable="true" data-type="table-input" name="'. $key . '" value="' . $value . '" placeholder="'. $placeholder .'">';
                        echo "</td>";
                    } else {
                        echo '<td>';
                        echo '<input type="date" onchange="updateDB(this)" contenteditable="true" data-type="table-input" name="'. $key . '" value="' . $value . '" placeholder="'. $placeholder .'">';
                        echo "</td>";
                    }
                    // check if "rent_paid" is true (1) false (0)
                } else if($key == 'rent_paid') {
                    if($value == null) {
                        echo '<td>';
                        echo '<input type="checkbox" onclick="updatePaidStatus(this)" class="form-check-label" contenteditable="true" name="'. $key . '" value="false">';
                        echo '<label for='.$key.'>Tenant Paid</label>';
                        echo '</td>';
                    } else if($value === 1) {
                        echo '<td class="alert-success">';
                        echo '<input type="checkbox" onclick="updatePaidStatus(this)" class="form-check-label alert-success" contenteditable="true" name="'. $key . '" value="true" checked>';
                        echo '<label for='.$key.'>Tenant Paid</label>';
                        echo '</td>';
                    }
                    echo $value;
                }
            }
            $action_td = '
                    <td>
                        <div class="d-flex flex-row align-items-center justify-content-around">
                            <div onclick="generateInvoice(this)" class="btn btn-warning">Invoice</div>
                            <div onclick="delete_row(this)" onmouseover="highlight_row(this)" onmouseout="unhighlight_row(this)" class="delete-icon" title="Click to delete row"></div>
                        </div>
                    </td>
                </tr>
            ';
            echo $action_td;
        }
    }
}

// This function will return negative numbers if the target date is before the origin date (current date), 
// and positive numbers if the target date is after the origin date (current date)
function calculate_date_diff($due_date) {
    $origin = new DateTimeImmutable($due_date);
    $target = new DateTimeImmutable("now");
    $diff = $origin->diff($target);

    $days = $diff->days;
    if($diff->invert) {
        $days = -$days;
    }

    return $days;
}