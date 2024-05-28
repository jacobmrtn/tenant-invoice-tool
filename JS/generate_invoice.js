function generateInvoice(cell) {

    let row = cell.parentNode.parentNode.parentNode.id;
    let row_element = document.getElementById(row);

    let row_data = {}  
    // row_element.childElementCount - 1 because we don't want to index the last table row element 
    for(let i = 0; i < row_element.childElementCount - 1; i ++) {
        let child = row_element.children[i].childNodes;
        let name_value = row_element.children[i].childNodes[0].name;

        row_data[name_value] = `${child[0].value}`;
    }

    if(row_data) {
        fetch("./includes/Templates/template_1.php", {
            method: "POST",
            body: JSON.stringify(row_data),
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => response.text())
            .then(data => {
                let file_name = data.replace(/\s/g, '');
                tcpdf_output(file_name);
            })

    } else {
        return;
    }
}

function tcpdf_output(file_name) {
    let f_name = {file_name: `${file_name}`}

    fetch("./includes/tcpdf_output.php", {
        method: "POST",
        body: JSON.stringify(f_name),
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.text())
        .then(() => {
            window.open(`Invoices/${file_name}.pdf`, "_blank");
        })

}