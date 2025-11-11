<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">

<?php
require_once 'classes/Db_conn.php';

$db = new DatabaseConn();
$conn = $db->dbOpen();

$message = "";

$firstName = $lastName = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $email = trim($_POST["email"]);
    $password1 = trim($_POST["password1"]);
    $password2 = trim($_POST["password2"]);

    if ($password1 === $password2 && !empty($firstName) && !empty($lastName) && !empty($email)) {
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first, :last, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':first', $firstName);
            $stmt->bindParam(':last', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            $message = "<p class='text-success'>You have been added to the database</p>";
            $firstName = $lastName = $email = "";
        } catch (PDOException $e) {
            $message = "<p class='text-danger'>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p class='text-danger'>Please make sure all fields are filled and passwords match.</p>";
    }
}
?>

<?= $message ?>

<form method="post" action="">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="firstName" value="<?= htmlspecialchars($firstName) ?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="lastName" value="<?= htmlspecialchars($lastName) ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="password1">Password</label>
                <input type="password" class="form-control" id="password1" name="password1">
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="password2">Confirm Password</label>
                <input type="password" class="form-control" id="password2" name="password2">
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" value="Register">
</form>

<?php
try {
    $stmt = $conn->query("SELECT first_name, last_name, email, password FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo "<table class='table table-bordered mt-2'>";
        echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th></tr>";

        foreach ($users as $user) {
            echo "<tr>
                    <td>" . htmlspecialchars($user['first_name']) . "</td>
                    <td>" . htmlspecialchars($user['last_name']) . "</td>
                    <td>" . htmlspecialchars($user['email']) . "</td>
                    <td>" . htmlspecialchars($user['password']) . "</td>
                  </tr>";
        }
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "<p class='text-danger'>Error fetching data: " . $e->getMessage() . "</p>";
}
?>

</div>

</body>
</html>