<?php

function load_templates() {
    $dir = 'templates';
    $files = scandir($dir);

    foreach($files as $file) {
        if($file != '.' && $file != '..') {
            $file_value = preg_replace('/\.\w+$/', '', $file);
            echo '<option value="'.$file_value.'">'.$file_value.'</option>';
            echo $file;
        }

    }


}