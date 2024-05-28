function addRow() {
    let table = document.getElementById('tenant_table');

    let row = table.insertRow();
    let new_row_id = `new_row_${table.rows.length}`;

    row.setAttribute('id', new_row_id);

    for(let i = 0; i < 9; i++) {
        let input = document.createElement('input');
        let cell = document.createElement('td');

        input.setAttribute('onchange', "updateDB(this)");
        input.setAttribute('contenteditable', true);
        input.setAttribute('type', "text");
        input.setAttribute("data-type", "table-input");
        cell.appendChild(input);
        row.appendChild(cell);

        switch(i) {
            case 0: 
                input.setAttribute('name', 'tenant_name');
                input.setAttribute('placeholder', 'Tenant Name');
                break;
            case 1: 
                input.setAttribute('name', 'tenant_address');
                input.setAttribute('placeholder', 'Tenant Address');
                break;
            case 2:
                input.setAttribute('name', 'monthly_rent');
                input.setAttribute('placeholder', 'Monthly Rent');
                break;
            case 3:
                input.setAttribute('name', 'rent_due_date');
                input.setAttribute('type', 'date');
                break;
            case 4: 
            // Check rent paid
                let checkbox_label = document.createElement('label');
                checkbox_label.setAttribute('for', 'rent_paid');
                checkbox_label.innerText = 'Tenant Paid';

                input.setAttribute('name', 'rent_paid');
                input.setAttribute('type', 'checkbox');
                input.setAttribute('class', 'form-check-label');
                input.setAttribute('onclick', 'updatePaidStatus(this)')

                cell.appendChild(checkbox_label);

                break;
            case 5: 
                input.setAttribute('name', 'rental_owner');
                input.setAttribute('placeholder', 'Rental Owner');
                break;
            case 6:
                input.setAttribute('name', 'owner_address');
                input.setAttribute('placeholder', 'Owner Address');
                break;
            case 7:
                input.setAttribute('name', 'owner_name');
                input.setAttribute('placeholder', 'Owner Name');
                break;
            case 8:

                let delete_icon = document.createElement('div');
                delete_icon.setAttribute('onclick', 'delete_row(this)');
                delete_icon.setAttribute('onmouseover', 'highlight_row(this)');
                delete_icon.setAttribute('onmouseout', 'unhighlight_row(this)');
                delete_icon.setAttribute('class', 'delete-icon');
                delete_icon.setAttribute('title', 'Click to delete row');

                let save_button = document.createElement('button');
                save_button.setAttribute('onclick', 'save_row(this)');
                save_button.innerText = "Save";
                save_button.setAttribute('class', 'btn btn-success');
            

                cell.appendChild(save_button);
                cell.appendChild(delete_icon);

                cell.setAttribute('class', "d-flex flex-row align-items-center justify-content-around");
                cell.removeChild(input);
                break;      
            default:
                console.log("How did you even get this?");
        }
    }   
}


async function updateRow() {
    const row_info = JSON.stringify( {
        "tenant_name": "Tenant Name",
        "tenant_address": "Tenant Address",
        "monthly_rent": "Monthly Rent",
        "rent_due_date": "0000-00-00",
        "rental_owner": "Rental Owner",
        "owner_address": "Owner Address",
        "owner_name": "Owner Name"
    })
    const response = await fetch("includes/tenant_add_row.inc.php", {
        method: "POST",
        body: row_info,
        headers: {
            "Content-Type": "application/json"
        }
    })

    return response.json();
}
