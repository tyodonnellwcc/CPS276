<?php
    $names = [];

    function addName() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['addName'])) {
                $names .= ['name'];
            }
    }

    function clearNames() {
        if(isset($_POST['clearNames'])) {
                $names = [];
        }
    }
?>