<?php 
    require_once 'includes/config_session.inc.php';
    require_once 'includes/signup_view.inc.php';
    require_once 'includes/login_view.inc.php';
    require_once 'includes/tenant_save_view.inc.php';
    require_once 'includes/tenant_load_table_model.inc.php';
    require_once 'includes/tenant_load_table_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/table.css">
    <link rel="stylesheet" href="CSS/resizeable_table_columns/resizable-table-columns.css">
    <title>Tenants</title>
</head>
<body onload="window.sessionStorage.clear()">
    <nav>
        <div class="table-contr d-flex">
            <button class="btn btn-primary">Invoice Options</button>
            <button class="btn btn-primary" onclick="addRow()">Add Row</button>
            <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown_filter_menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown button</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="tenant_name_filter">
                    <label class="form-check-label" for="defaultCheck1">Tenant Name</label>
                </div>
                <a class="dropdown-item" href="#">Another action</a>    
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
            </div>
            <!-- <button onclick="checkTable()">Check tbl</button> -->
        </div>
        <div class="account-contr">
            <button class="logout-button btn btn-danger" onclick="confirm_logout()">Logout of <?php output_username()?></button>
        </div>
    </nav>
    <?php if(isset($_SESSION["user_id"])) {?>
        <form action="includes/tenant_save.inc.php" method="post" onkeydown="return event.key != 'Enter'">
            <article>
                <table id="tenant_table" class="data table table-bordered rtc-wrapper" data-rtc-resizable-table="table.one">
                    <thead class="thead-light">
                        <tr>
                            <th>Tenant Name</th>
                            <th data-rtc-resizable="tenant_address">Tenant Address</th>
                            <th data-rtc-resizable="monthly_rent">Monthly Rent</th>
                            <th data-rtc-resizable="due_date">Due Date</th>
                            <th data-rtc-resizable="rent_paid">Rent Paid</th>
                            <th data-rtc-resizable="rental_owner">Rental Owner</th>
                            <th data-rtc-resizable="owner_address">Owner Address</th>
                            <th data-rtc-resizable="owner_name">Owner Name</th>
                            <th id="actions_header">Actions</th>
                        </tr>
                    </thead>
                    <?php if(isset($_SESSION["user_tenant_table"])) {
                        display_tenant_table();
                        error_table_input();
                    } ?>
                </table>
            </article>
            <?php check_save_errors() ?>
        </form>
    <?php } else if(!isset($_SESSION["user_id"])) {header("Location ./login.php");} ?>
    <script src="JS/resizeable_table_columns/index.js"></script>
    <script src="JS/resizeable_table_columns/store.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="JS/bootstrap/bootstrap.js"></script>
    <script src="JS/update-db-api.js"></script>
    <script src="JS/add-row.js"></script>
    <script src="JS/functions.js"></script>
    <script src="JS/generate_invoice.js"></script>
    <script>
        (function (window, ResizableTableColumns, undefined) {
            var store = window.store && window.store.enabled
                ? window.store
                : null;

            var els = document.querySelectorAll('table.data');
            for (var index = 0; index < els.length; index++) {
                var table = els[index];
                if (table['rtc_data_object']) {
                    continue;
                }

                var options = {
                    store: store,
                    maxInitialWidth: 100
                };
                if (table.querySelectorAll('thead > tr').length > 1) {
                    options.resizeFromBody = false;
                }

                new ResizableTableColumns(els[index], options);
            }

        })(window, window.validide_resizableTableColumns.ResizableTableColumns, void (0));
    </script>
</body>
</html>