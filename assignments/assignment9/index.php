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
require_once 'classes/Validation.php';

$firstName = $lastName = $email = '';
$errors = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);

    $validator = new Validation();

    $validator->checkFormat($firstName, 'first_name');
    $validator->checkFormat($lastName, 'last_name');
    $validator->checkFormat($email, 'email');
    $validator->checkFormat($password1, 'password');

    if ($password1 !== $password2) {
        $validator->checkFormat('', 'password', 'Passwords do not match.');
    }

    $errors = $validator->getErrors();

    if (!$validator->hasErrors()) {
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

        try {
            $db = new DatabaseConn();
            $conn = $db->dbOpen();

            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $errors['email'] = 'Email already exists.';
            } else {
                $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (:first, :last, :email, :password)");
                $stmt->bindParam(':first', $firstName);
                $stmt->bindParam(':last', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();

                $message = "<p class='text-success'>You have been added to the database</p>";

                $firstName = $lastName = $email = '';
            }
        } catch (PDOException $e) {
            $message = "<p class='text-danger'>Database error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<?= $message ?>

<form method="post" action="">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>" 
                   id="first_name" name="firstName" value="<?= htmlspecialchars($firstName) ?>">
            <?php if (isset($errors['first_name'])): ?>
                <div class="text-danger"><?= $errors['first_name'] ?></div>
            <?php endif; ?>
        </div>

        <div class="col-md-6 mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>" 
                   id="last_name" name="lastName" value="<?= htmlspecialchars($lastName) ?>">
            <?php if (isset($errors['last_name'])): ?>
                <div class="text-danger"><?= $errors['last_name'] ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="email">Email</label>
            <input type="text" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                   id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="text-danger"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="col-md-4 mb-3">
            <label for="password1">Password</label>
            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                   id="password1" name="password1">
            <?php if (isset($errors['password'])): ?>
                <div class="text-danger"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>

        <div class="col-md-4 mb-3">
            <label for="password2">Confirm Password</label>
            <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                   id="password2" name="password2">
        </div>
    </div>

    <input type="submit" class="btn btn-primary" value="Register">
</form>

<?php
try {
    if (isset($conn)) {
        $stmt = $conn->query("SELECT first_name, last_name, email, password FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            echo "<table class='table table-bordered mt-3'>";
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
    }
} catch (PDOException $e) {
    echo "<p class='text-danger'>Error fetching data: " . $e->getMessage() . "</p>";
}
?>

</div>
</body>
</html>