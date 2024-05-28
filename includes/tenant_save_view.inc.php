<?php

declare(strict_types=1);

function error_table_input() {
    if(isset($_SESSION["table_data"])) {
        $table_data = $_SESSION["table_data"];
        echo '<tr>';

        foreach($table_data as $key => $value ) {

            // Remove the "_" from $key, then uppercase first letter of each word
            $placeholder = str_replace("_", " ", $key);
            $placeholder = ucwords($placeholder);

            // Change placeholder value if $placeholder needs to be a calendar format 
            if($placeholder == "Rent Due Date") {
                $placeholder = "YYYY-MM-DD";
            }
            
            if($key != "rent_due_date") {
                echo "<td>";
                echo '<input "contenteditable="true" type="text" data-type="table-input" name="'. $key . '" value="' . $value . '" placeholder="'. $placeholder . '">';
                echo "</td>";
            } else if($key == "rent_due_date") {
                echo "<td>";
                echo '<input type="date" onchange="updateDB(this)" contenteditable="true" data-type="table-input" name="'. $key . '" value="' . $value . '" placeholder="'. $placeholder .'">';
                echo "</td>";
            }


        }

        $action_td = '
                <td class="d-flex flex-row align-items-center justify-content-around">
                    <button onclick="save_row(this)" class="btn btn-success">Save</button>
                    <div onclick="delete_row(this)" class="delete-icon" title="Click to delete row"></div>
                </td>
            </tr>
        ';

        echo $action_td;
    }
}
function check_save_errors() {
    if(isset($_SESSION['tenant_errors_incomplete_table'])) {
        $errors = $_SESSION['tenant_errors_incomplete_table'];

        echo "<br>";

        foreach($errors as $error) {
            $bootstrap_dismissible = '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong>' .$error.'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <script> $("alert").alert()</script>
            ';
            echo $bootstrap_dismissible;
        }

        unset( $_SESSION['tenant_errors_incomplete_table']);
        unset($_SESSION['table_data']);

    } else if (isset($_GET["save"]) && $_GET["save"] === 'success') {
        echo '<br>';
        echo '<p class="form-success">Save success!</p>';
    }
}
