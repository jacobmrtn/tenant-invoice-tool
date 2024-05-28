function updateDB(row) {
    // Check if row parentElement has an ID. 
    if(row.parentElement.parentElement.getAttribute('id').includes('_')) {
        return;
    } 

    let db_data = create_db_post_data(row);
    fetch("./includes/tenant_save_cell.inc.php", {
        method: "POST",
        body: JSON.stringify(db_data),
        headers: {
            "Content-Type": "application/json"
        }
    });
}

function create_db_post_data(cell) {
    let row_id = cell.parentElement.parentElement.getAttribute('id');
    let row_element = document.getElementById(row_id);
    
    let post_data = {
        "row_id": row_id,
    };

    // row_element.childElementCount - 1 because we don't want to index the last table row element 
    for(let i = 0; i < row_element.childElementCount - 1; i ++) {
        let child = row_element.children[i].childNodes;
        let name_value = row_element.children[i].childNodes[0].name;
        post_data[name_value] = `${child[0].value}`;
    }
    return post_data;   
}