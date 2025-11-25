<?php
require_once("../classes/Pdo_methods.php");

$pdo = new PdoMethods();

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || trim($data->name) === "") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "Name cannot be empty"
    ]);
    exit;
}

$parts = explode(" ", trim($data->name));

if (count($parts) < 2) {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "You must enter first and last name"
    ]);
    exit;
}

$firstname = array_shift($parts);
$lastname = implode(" ", $parts);

// Insert
$sql = "INSERT INTO names (firstname, lastname) VALUES (:first, :last)";
$bindings = [
    [":first", $firstname, "str"],
    [":last", $lastname, "str"]
];

$result = $pdo->otherBinded($sql, $bindings);

if ($result === "error") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "Database insert failed"
    ]);
} else {
    echo json_encode([
        "masterstatus" => "success",
        "msg" => "Name added successfully"
    ]);
}
?>