<?php
require_once 'classes/PdoMethods.php';

$output = "";

if (isset($_POST['fileUpload'])) {

    $fileName = trim($_POST['fileName']);
    $file = $_FILES['file'];

    if ($fileName === "") {
        $output = "<p class='text-danger'>Please enter a file name.</p>";
        return;
    }

    if ($file['error'] !== 0) {
        $output = "<p class='text-danger'>A file is required.</p>";
        return;
    }

    if ($file['type'] !== "application/pdf") {
        $output = "<p class='text-danger'>Only PDF files are allowed.</p>";
        return;
    }

    if ($file['size'] > 100000) {
        $output = "<p class='text-danger'>File must be under 100,000 bytes.</p>";
        return;
    }

    $uploadPath = "assignment7/files/" . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $output = "<p class='text-danger'>Error uploading file.</p>";
        return;
    }

    $pdo = new PdoMethods();
    $sql = "INSERT INTO pdf_files (file_name, file_path) VALUES (:fileName, :filePath)";
    $bindings = [
        [':fileName', $fileName, 'str'],
        [':filePath', "files/" . basename($file['name']), 'str']
    ];

    $result = $pdo->otherBinded($sql, $bindings);

    if ($result === 'noerror') {
        $output = "<p class='text-success'>File successfully uploaded!</p>";
    } else {
        $output = "<p class='text-danger'>Database error.</p>";
    }
}
?>