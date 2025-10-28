<?php
require_once 'classes/PdoMethods.php';

$output = "";

$pdo = new PdoMethods();
$sql = "SELECT file_name, file_path FROM uploadedfiles";

$records = $pdo->selectNotBinded($sql);

if ($records === 'error' || count($records) === 0) {
    $output = "<li>No files uploaded yet.</li>";
} else {
    foreach ($records as $row) {
        $output .= "<li><a target='_blank' href='{$row['file_path']}'>{$row['file_name']}</a></li>";
    }
}
?>