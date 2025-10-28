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

    $uploadDir = "/home/t/y/tyodonnell/public_html/cps276/assignments/assignment7/files/";
    $uploadPath = $uploadDir . basename($file['name']);

    if (file_exists($uploadPath)) {
        unlink($uploadPath);
    }

    $fileData = file_get_contents($file['tmp_name']);
    if ($fileData === false) {
        $output = "<p class='text-danger'>Unable to read uploaded file.</p>";
        return;
    }

    if (file_put_contents($uploadPath, $fileData) === false) {
        $output = "<p class='text-danger'>Error saving uploaded file to destination.</p>";
        return;
    }

    unlink($file['tmp_name']);

    $pdo = new PdoMethods();
    $sql = "INSERT INTO uploadedfiles (file_name, file_path) VALUES (:fileName, :filePath)";
    $bindings = [
        [':fileName', $fileName, 'str'],
        [':filePath', "files/" . basename($file['name']), 'str']
    ];

    $result = $pdo->otherBinded($sql, $bindings);

    if ($result === 'noerror') {
        $output = "<p class='text-success'>File successfully uploaded!</p>";
    } else {
        $output = "<p class='text-danger'>Database error while saving file info.</p>";
    }
}
?>