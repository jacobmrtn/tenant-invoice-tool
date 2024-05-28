// logout function - check if user confirms -> then call logout API
function confirm_logout() {
    let logout = confirm("Are you sure you want to logout? Any unsaved items will be lost!");
    if(logout == true) {
        fetch("./includes/logout.inc.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        })
        window.location.reload();
    } else {
        return;
    }
}

// Checkbox function 
function checked(cell) {
    let isChecked = cell.getAttribute("data-checked");
    let row_id = cell.parentElement.parentElement.parentElement.getAttribute('id');
    let row_element = document.getElementById(row_id);

    let row_data = {}  

    // row_element.childElementCount - 2 because we don't want to index the last table row element 
    for(let i = 0; i < row_element.childElementCount - 1; i ++) {
        let child = row_element.children[i].childNodes;
        let name_value = row_element.children[i].childNodes[0].name;

        row_data[name_value] = `${child[0].value}`;
    }

    if(isChecked == "false") {
        cell.setAttribute('data-checked', "true");
        cell.style.backgroundColor = "#ffcc00";
        // add checked checkbox row to localstorage 
        sessionStorage.setItem(`row_${row_id}`, JSON.stringify(row_data));
    } else if(isChecked  == "true") {
        cell.setAttribute('data-checked', "false");
        cell.style.backgroundColor = 'white';
        // remove unchecked checkbox row from localstorage
        sessionStorage.removeItem(`row_${row_id}`);
    }
}

// Delete row from database 
function delete_row(row) {

    let confirm_delete = confirm("Are you sure you want to delete this tenant? This action cannot be reversed!");

    if(confirm_delete == true && row.parentElement.parentElement.parentElement.id) {
        let parent_id = row.parentElement.parentElement.parentElement.id;

        // get the data base row ID from the table row ID attribute
        let db_row_id = parent_id;
        let post_info = JSON.stringify( {
            "row_id": db_row_id
        })
    
        fetch("/includes/tenants_delete.inc.php", {
            method: "POST",
            body: post_info,
            headers: {
                "Content-Type": "application/json"
            }
        })

        let row_index = row.parentNode.parentNode.parentNode.rowIndex;
        document.getElementById('tenant_table').deleteRow(row_index);
    } else if(confirm_delete == true && row.parentElement.parentElement.id) {
        let row_index = row.parentNode.parentNode.rowIndex;
        document.getElementById('tenant_table').deleteRow(row_index);
    } else if(confirm_delete == true) {
        row.parentElement.parentElement.parentNode.removeChild(row.parentElement.parentElement);
    }

}

// add highlight to row when user moves mouse over delete icon 
function highlight_row(row) {
    // let parent_id = row.parentElement.parentElement.id;
    // let element = document.getElementById(parent_id);

    // element.style.outline = "3px solid #fa5252";
    // element.style.borderRadius = "3px";
    return;
}

// remove highlight from row when user takes mouse off delete icon 
function unhighlight_row(row) {
    // let parent_id = row.parentElement.parentElement.id;
    // let element = document.getElementById(parent_id);

    // element.style.outline = "none";
    // element.style.borderRadius = "none";
    return;
}

// Save newly added row 
function save_row(cell) {

    let row = cell.parentNode.parentNode.id;
    let row_element = document.getElementById(row);

    let row_data = {}  
    
    // row_element.childElementCount - 1 because we don't want to index the last table row element 
    for(let i = 0; i < row_element.childElementCount - 1; i ++) {
        let child = row_element.children[i].childNodes;
        let name_value = row_element.children[i].childNodes[0].name;

        row_data[name_value] = `${child[0].value}`;
    }


    fetch("/includes/tenant_save.inc.php", {
        method: "POST",
        body: JSON.stringify(row_data),
        headers: {
            "Content-Type": "application/json"
        }
    })
}

// Send paid status to DB -> add .alert-success to cell else -> remove .alert-success
function updatePaidStatus(that) {
    let status = that.checked;
    let cell = that.parentNode;
    let parent_id = that.parentNode.parentNode.id;

    // if checked
    if(status == true) {
        that.setAttribute('class', 'alert-success');
        cell.setAttribute('class', 'alert-success');
        that.setAttribute('value', true);

        let post_info = JSON.stringify({
            "row_id": parent_id,
            "paid_status": true
        }) 
        
        send_db_data(post_info);
    
        // if not checked
    } else if(status == false){
        that.removeAttribute('class', 'alert-success');
        cell.removeAttribute('class', 'alert-success');
        that.setAttribute('value', false);

        let post_info = JSON.stringify({
            "row_id": parent_id,
            "paid_status": false
        })
        
        send_db_data(post_info);
    }


    // send info to php script 
    function send_db_data(post_info) {
        fetch("includes/tenant_update_paid_status.inc.php", {
            method: "POST",
            body: post_info,
            headers: {
                "Content-Type": "application/json"
            }
        })
    }
}