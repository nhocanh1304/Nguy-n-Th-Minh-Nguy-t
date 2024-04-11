<?php
    $_servername = "localhost";
    $_username = "root";
    $_password = "";
    $_dbname = "btec-student";

    // Create connection
    $connection = new mysqli($_servername, $_username, $_password, $_dbname);

    $id = "";
    $fullname = "";
    $email = "";
    $password = "";
    $Masv = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $Masv = $_POST['Masv'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
  

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_result = $connection->query($check_sql);

        if ($check_result->num_rows > 0) {
            $errorMessage = "Error: Email already exists in the system.";
        } else {
            if (empty($id) || empty($fullname) || empty($email) || empty($password) || empty($Masv)) {
                $errorMessage = "Complete student information is required";
            } else {
                // Add new student to the database
                $stmt = $connection->prepare("INSERT INTO users (id, fullname, email, password, Masv) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $id, $fullname, $email, $hashed_password, $Masv);

                if ($stmt->execute()) {
                    $id = "";
                    $fullname = "";
                    $email = "";
                    $password = "";
                    $Masv = "";
                    $successMessage = "Student added correctly";

                    header("location: home_page.php");
                    exit;
                } else {
                    $errorMessage = "Error executing query: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Add Student</h2>
        <form method="POST" action="add_page.php">
            <div class="mb-4">
                <label for="id" class="block mb-2 font-bold">ID:</label>
                <input type="text" name="id" class="border border-gray-300 rounded px-4 py-2" value="<?= htmlspecialchars($id) ?>">
            </div>

            <div class="mb-4">
                <label for="fullname" class="block mb-2 font-bold">Full Name:</label>
                <input type="text" name="fullname" class="border border-gray-300 rounded px-4 py-2" value="<?= htmlspecialchars($fullname) ?>">
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-2 font-bold">Email:</label>
                <input type="email" name="email" class="border border-gray-300 rounded px-4 py-2" value="<?= htmlspecialchars($email) ?>">
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-2 font-bold">Password:</label>
                <input type="password" name="password" class="border border-gray-300 rounded px-4 py-2">
            </div>

            <div class="mb-4"
                label for="Masv" class="block mb-2 font-bold">masv:</label>
                <input type="Masv" name="Masv" class="border border-gray-300 rounded px-4 py-2" value="<?= htmlspecialchars($Masv) ?>">

            </div>

            <div>
                <input type="submit" value="Add Student" class="bg-blue-500 text-black px-4 py-2 rounded cursor-pointer">

                <a class="btn btn-outline-primary bg-blue-500 text-white px-4 py-2 rounded cursor-pointer" href="home_page.php" role="button">Cancel</a>
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