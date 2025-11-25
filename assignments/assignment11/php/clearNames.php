<?php
require_once("../classes/Pdo_methods.php");

$pdo = new PdoMethods();

$sql = "TRUNCATE TABLE names";

$result = $pdo->otherNotBinded($sql);

if ($result === "error") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "Failed to clear names"
    ]);
} else {
    echo json_encode([
        "masterstatus" => "success",
        "msg" => "All names have been cleared"
    ]);
}
?>