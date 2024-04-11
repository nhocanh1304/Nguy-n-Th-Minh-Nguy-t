<?php
$_servername = "localhost";
$_username = "root";
$_password = "";
$_dbname = "btec-student";

// Create connection
$connection = new mysqli($_servername, $_username, $_password, $_dbname);

$id = $fullname = $email = $password = $errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $masv = $_POST['masv'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE email = '$email' AND id != '$id'";
    $check_result = $connection->query($check_sql);

    if ($check_result->num_rows > 0) {
        $errorMessage = "Error: Email already exists in the system.";
    } else {
        if (empty($id) || empty($fullname) || empty($email) || empty($password) || empty($Masv)) {
            $errorMessage = "Complete student information is required";
        } else {
            // Update student information in the database
            $sql = "UPDATE users SET fullname = '$fullname', email = '$email', id = '$id', password = '$password', Masv = '$Masv'";

            // Update password if provided
            if (!empty($password)) {
                $sql .= ", password = '$hashed_password'";
            }

            $sql .= " WHERE id = '$id'";

            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
            } else {
                $id = $fullname = $email = $password = "";
                $successMessage = "Student information updated correctly";
                header("location: home_page.php");
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mx-auto p-4">
    <h2 class="text-4xl font-bold mb-8 text-center">Update Student</h2>
    <form method="POST" action="">
        <div class="mb-4">
            <label for="id" class="block mb-2 font-bold">ID:</label>
            <input type="text" name="id" class="form-control" value="<?= htmlspecialchars($id) ?>">
        </div>

        <div class="mb-4">
            <label for="fullname" class="block mb-2 font-bold">Full Name:</label>
            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($fullname) ?>">
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 font-bold">Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-2 font-bold">Password:</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-4"
            label for="masv" class="block mb-2 font-bold">masv:</label>
            <input type="masv" name="masv" class="form-control" >
         </div>


        <div class="flex justify-center space-x-4 mt-8">
            <button type="submit" class="btn btn-primary">Update Student</button>
            <a class="btn btn-secondary" href="home_page.php" role="button">Cancel</a>
        </div>
    </form>

    <?php if (!empty($errorMessage)): ?>
        <p class="text-red-500 mt-4"><?= $errorMessage ?></p>
    <?php endif; ?>

    <?php if (!empty($successMessage)): ?>
        <p class="text-green-500 mt-4"><?= $successMessage ?></p>
    <?php endif; ?>
</div>
</body>
</html>