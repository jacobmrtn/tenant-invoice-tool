<?php 
    require_once 'load_templates.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


    <title>Invoice Editor</title>
</head>
<body>

    <div style="display:flex; flex-direction: row; align-items: center;">

        <div>
            <h1 id="current_invoice">Invoice Editor</h1>
            <form method="post" style="width: 8.5in; height: 11in;">
                <div id="editor" name="editordata"></div>
                <button id="save-btn" class="btn btn-primary">Save</button>
            </form>
        </div>

        <div>
            <label for="invoices">Select Invoice</label>
            <select name="invoices" id="invoice_select">
                <option value="select">Select Invoice -- </option>
                <?php load_templates();?>
            </select>

            <button id="create_invoice">Create New Invoice</button>
            <div id="new_invoice_ui" style="display: none;">
                <input id="new_invoice_name" type="text" placeholder="Template Name">
                <button id="save_new_invoice">Save</button>
                <button id="cancel_new_invoice">Cancel</button>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#invoice_select').on("change", function() {
                if(this.value != "select") {
                    let content = `templates/${this.value}.html`;
                    $.ajax ({
                        url: 'recall_template.php',
                        type: 'POST',
                        data: {content: content},
                        success: function(response) {
                            document.getElementById('current_invoice').innerText = `Invoice Editor (${content})`;
                            $('#editor').summernote('reset');
                            $('#editor').summernote('editor.pasteHTML', response);
                            $('#editor').summernote('enable');
                        }
                    })
                } else {
                    return;
                }
            })

            $('#create_invoice').on("click", function() {
               document.getElementById('new_invoice_ui').style = 'display: block;';
            })

            $('#cancel_new_invoice').on("click", function() {
                document.getElementById("new_invoice_name").value = null;
                document.getElementById('new_invoice_ui').style = 'display: none;';
            });

            $('#save_new_invoice').on("click", function() {
                let invoice_value = document.getElementById("new_invoice_name").value;
                let invoice_name =  `${invoice_value}.html`;

                let path_name = `templates/${invoice_value}.html`;

                $.ajax({
                    url: 'create_template.php',
                    type: 'POST',
                    data: {file_name: path_name.replace(/\s/g, "_")},
                    success: function(response) {
                        let invoices = document.getElementById('invoice_select');
                        let new_invoice = document.createElement('option');
                        // remove whitespace from invoice name
                        let new_invoice_value = invoice_name.replace(/\s/g, "_");

                        new_invoice.setAttribute('value', new_invoice_value);
                        new_invoice.innerText = invoice_name;

                        // add new invoice to the invoice list
                        invoices.appendChild(new_invoice);

                        document.getElementById('current_invoice').innerText = `Invoice Editor (${invoice_name})`;
                        $('#editor').summernote('reset');

                        document.getElementById("new_invoice_name").value = null;
                        document.getElementById('new_invoice_ui').style = 'display: none;'
                    }
                });
            });

            $('#editor').summernote({
                height: "11in",
                tabDisable: true,
                disableDragAndDrop: true,
                placeholder: 'Please select invoice!',
                toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['help']]
                ]
            });

            $('#editor').summernote('disable');

            $('#save-btn').click(function() {
                let content = $('#editor').summernote('code');
                let file = document.getElementById('invoice_select').value
                console.log(file);
                // Send data to server using AJAX
                $.ajax ({
                url: 'save_template.php',
                type: 'POST',
                data: {content: content, file: file}
               });
            });
        });
    </script>
</body>
</html>