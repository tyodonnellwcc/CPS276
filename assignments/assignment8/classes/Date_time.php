<?php
//Table name: note
//Table attributes: id(pri), date_time, note

require_once 'classes/Pdo_methods.php';

$output = " ";

    if (isset($_POST['addNote'])) {
        
        if($_POST['note'] === "") {
            $output = "<p class='text-danger'>Please enter a note.</p>";
            return;
        }

        //not sure if I need this
        $uploadDir = "/home/t/y/tyodonnell/public_html/cps276/assignments/assignment8/note/";
    }

?>