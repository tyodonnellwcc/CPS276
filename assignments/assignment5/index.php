<?php
require_once "classes/Directories.php";

$message = "";
$link = "";

if (isset($_POST['submit'])) {
    $directoryName = trim($_POST['directoryname']);
    $fileContent = trim($_POST['filecontent']);

    $dir = new Directories($directoryName, $fileContent);
    $result = $dir->createDirectoryAndFile();

    if ($result['status'] === 'success') {
        $message = "<p>File and directory were created</p>";
        $link = "<p><a target='_blank' href='directories/{$directoryName}/readme.txt'>Path where file is located</a></p>";
    } else {
        $message = "<p class='text-danger'>{$result['message']}</p>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File and Directory</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container mt-4">
      <h1>File and Directory Assignment</h1>
      <p>Enter a folder name and the contents of a file. Folder names should contain alphabetic characters only.</p>

      <!-- Display messages -->
      <?= $message ?>
      <?= $link ?>

      <form method="post" action="index.php">
        <div class="form-group">
          <label for="directoryname">Folder Name</label>
          <input type="text" class="form-control" id="directoryname" name="directoryname" required>
        </div>
        <div class="form-group">
          <label for="filecontent">File Content</label>
          <textarea id="filecontent" name="filecontent" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </form>
    </div>
  </body>
</html>