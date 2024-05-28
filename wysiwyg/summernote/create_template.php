<?php 

$file_name = $_POST['file_name'];

if(file_exists($file_name)) {
    echo 'File already exist. Choose a different name';
} else {
    file_put_contents($file_name, '');
}