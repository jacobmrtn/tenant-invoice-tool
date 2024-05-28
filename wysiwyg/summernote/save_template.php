<?php

$content = $_POST['content'];
$file = $_POST['file'];

echo $file;

if(file_put_contents($file, $content) !== false) {
    echo 'Template Saved!';
} else {
    echo 'Error: Unable to save content.';
}