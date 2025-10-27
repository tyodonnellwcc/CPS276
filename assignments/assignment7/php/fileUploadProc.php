<?php
require_once '../classes/Pdo_methods.php';

$output = "";

if (isset($_POST['fileUpload'])) {

    $fileName = trim($_POST['fileName']);
    $file = $_FILES['file'];

    // Validate name entered
    if ($fileName === "") {
        $output = "<p class='text-danger'>Please enter a file name.</p>";
        return;
    }

    // Validate file present
    if ($file['error'] !== 0) {
        $output = "<p class='text-danger'>A file is required.</p>";
        return;
    }

    // Validate PDF and size
    if ($file['type'] !== "application/pdf") {
        $output = "<p class='text-danger'>Only PDF files are allowed.</p>";
        return;
    }

    if ($file['size'] > 100000) {
        $output = "<p class='text-danger'>File must be under 100,000 bytes.</p>";
        return;
    }

    // Move file to server folder
    $uploadPath = "../files/" . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $output = "<p class='text-danger'>Error uploading file.</p>";
        return;
    }

    // Store in database
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