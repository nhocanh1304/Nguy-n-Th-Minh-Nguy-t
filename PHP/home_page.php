<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Product List</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-2xl font-bold mb-4">List of Students</h2>
        <a class="btn btn-primary mb-4" href="add_page.php" role="button">Add Students</a>
        
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b">ID</th>
                        <th class="border-b">Fullname</th>
                        <th class="border-b">Email</th>
                        <th class="border-b">Password</th>
                        <th class="border-b">MaSV</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection settings
                    $_servername = "localhost";
                    $_username = "root";
                    $_password = "";
                    $_dbname = "btec-student";

                    // Create connection;
                    $conn = new mysqli($_servername, $_username, $_password, $_dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Read all rows from database table
                    $query = "SELECT * FROM users";
                    $result = $conn->query($query);

                    if (!$result) {
                        die("Invalid query: "  .  $conn->error);
                    }

                    // Read data of each row
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><?php echo $row['Masv']; ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="update_page.php">Update</a>
                                <a class="btn btn-primary btn-sm" href="delete_page.php">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>