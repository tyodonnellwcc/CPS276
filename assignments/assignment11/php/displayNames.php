<?php
require_once("../classes/Pdo_methods.php");

$pdo = new PdoMethods();

$sql = "SELECT firstname, lastname FROM names ORDER BY lastname, firstname";
$records = $pdo->selectNotBinded($sql);

if ($records === "error") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "Could not retrieve names"
    ]);
    exit;
}

if (count($records) === 0) {
    echo json_encode([
        "masterstatus" => "success",
        "names" => "<p>No names to display.</p>"
    ]);
    exit;
}

$list = "<ul>";
foreach ($records as $r) {
    $list .= "<li>{$r['lastname']}, {$r['firstname']}</li>";
}
$list .= "</ul>";

echo json_encode([
    "masterstatus" => "success",
    "names" => $list
]);
?>