<?php
// Start session and include database connection
session_start();
require_once 'db.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    // Redirect to admin login page if not logged in as admin
    header("Location: admin_login.php");
    exit();
}

// Fetch all user data from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007BFF;
            color: white;
        }
        .remove-button {
            color: white;
            background-color: red;
        }
        .back-button {
            width: 120px;
            margin-top: 20px;
            display: block;
            text-align: center;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mt-4">User Management</h2>
    
    <!-- Back Button -->
    <a href="dashboard.php" class="back-button">Back to Dashboard</a>

    <div class="card">
        <div class="card-header">
            User List
        </div>
        <div class="card-body">
            <?php if ($result->rowCount() > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['mobile_number']; ?></td>
                                <td>
                                    <form action="userview.php" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="remove" class="btn remove-button">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Handle user removal logic
if (isset($_POST['remove'])) {
    $user_id = $_POST['user_id'];

    // Prepare SQL query to delete the user
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        echo "Error preparing query: " . $conn->error;
    } else {
        // Bind the user_id to the prepared statement
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);

        // Execute the statement and handle success or failure
        if ($stmt->execute()) {
            // Alert and refresh the page to reflect the changes
            echo "<script>alert('User removed successfully!');</script>";
            echo "<meta http-equiv='refresh' content='0'>"; // Refresh page
        } else {
            echo "Error removing user: " . $stmt->error;
        }
    }
}
?>

</body>
</html>
