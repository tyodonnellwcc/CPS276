<?php
        function addClearNames() {
    $namesString = "";
    if (isset($_POST['namelist'])) {
        $namesString = trim($_POST['namelist']);
    }

    $namesArray = [];
    if ($namesString !== "") {
        $namesArray = explode("\n", $namesString);
    }

    if (isset($_POST['addName'])) {
        $fullName = "";
        if (isset($_POST['name'])) {
            $fullName = trim($_POST['name']);
        }

        $splitName = explode(" ", $fullName, 2);
        if (count($splitName) === 2) {
            $firstName = ucwords(strtolower($splitName[0]));
            $lastName  = ucwords(strtolower($splitName[1]));

            $formatNames = $lastName . ", " . $firstName;

            $namesArray[] = $formatNames;
        }

        sort($namesArray);
        return implode("\n", $namesArray);
    }

    if (isset($_POST['clearNames'])) {
        return "";
    }
}

?>