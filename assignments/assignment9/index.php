<?php
require_once 'classes/StickyForm.php';
require_once 'classes/Validation.php';
require_once 'classes/Pdo_methods.php';
require_once 'classes/Db_conn.php';

$stickyForm = new StickyForm();
$valid = new Validation();
$pdo = new PdoMethods();

$message = "";
$formElements = [
  "first_name" => "", "last_name" => "", "email" => "",
  "password" => "", "confirm_password" => "",
  "first_name_error" => "", "last_name_error" => "",
  "email_error" => "", "password_error" => "", "confirm_password_error" => ""
];

if (isset($_POST['submit'])) {
  $formElements = $stickyForm->validateForm($_POST);

  if ($formElements['masterStatus']['status'] == "noerrors") {
    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = :email";
    $bindings = [
      [':email', $_POST['email'], 'str']
    ];
    $records = $pdo->selectBinded($sql, $bindings);

    if (count($records) > 0) {
      $message = "<p class='error'>Email already exists. Try another one.</p>";
    } else {
      // Hash password
      $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // Insert user record
      $sql = "INSERT INTO users (first_name, last_name, email, password)
              VALUES (:first_name, :last_name, :email, :password)";
      $bindings = [
        [':first_name', $_POST['first_name'], 'str'],
        [':last_name', $_POST['last_name'], 'str'],
        [':email', $_POST['email'], 'str'],
        [':password', $hashed, 'str']
      ];
      $result = $pdo->otherBinded($sql, $bindings);

      if ($result === 'error') {
        $message = "<p class='error'>There was a problem adding the record.</p>";
      } else {
        $message = "<p class='success'>User successfully registered.</p>";
        foreach ($formElements as $key => $value) {
          if (!str_contains($key, '_error')) $formElements[$key] = "";
        }
      }
    }
  } else {
    $message = "<p class='error'>Please correct the highlighted errors below.</p>";
  }
}

// Retrieve all users to display
$display = "";
$sql = "SELECT * FROM users ORDER BY reg_date DESC";
$records = $pdo->selectNotBinded($sql);
if ($records === 'error' || count($records) == 0) {
  $display = "<p>No registered users yet.</p>";
} else {
  $display = "<table border='1' cellpadding='5'><tr>
                <th>First Name</th><th>Last Name</th>
                <th>Email</th><th>Registered</th></tr>";
  foreach ($records as $row) {
    $display .= "<tr><td>{$row['first_name']}</td><td>{$row['last_name']}</td>
                 <td>{$row['email']}</td><td>{$row['reg_date']}</td></tr>";
  }
  $display .= "</table>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Registration</title>
<style>
  body { font-family: Arial, sans-serif; width: 700px; margin: 30px auto; }
  .error { color: red; }
  .success { color: green; }
  label { display: inline-block; width: 150px; }
  input[type=text], input[type=password], input[type=email] { width: 250px; }
</style>
</head>
<body>

<h2>User Registration Form</h2>
<?= $message ?>

<form method="post" action="">
  <p>
    <label>First Name:</label>
    <input type="text" name="first_name" value="<?= $formElements['first_name'] ?>">
    <span class="error"><?= $formElements['first_name_error'] ?></span>
  </p>
  <p>
    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?= $formElements['last_name'] ?>">
    <span class="error"><?= $formElements['last_name_error'] ?></span>
  </p>
  <p>
    <label>Email:</label>
    <input type="email" name="email" value="<?= $formElements['email'] ?>">
    <span class="error"><?= $formElements['email_error'] ?></span>
  </p>
  <p>
    <label>Password:</label>
    <input type="password" name="password" value="">
    <span class="error"><?= $formElements['password_error'] ?></span>
  </p>
  <p>
    <label>Confirm Password:</label>
    <input type="password" name="confirm_password" value="">
    <span class="error"><?= $formElements['confirm_password_error'] ?></span>
  </p>
  <p><input type="submit" name="submit" value="Register"></p>
</form>

<h3>Registered Users</h3>
<?= $display ?>

</body>
</html>