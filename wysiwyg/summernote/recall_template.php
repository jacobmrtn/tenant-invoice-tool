<?php

$file = $_POST['content'];

if(file_get_contents($file) !== false) {
    echo file_get_contents($file);
} else {
    echo 'Error: Unable to fetch content.';
}