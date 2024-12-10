<?php
// Start session and include database connection
session_start();
require_once 'db.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get filter value from the request (default to "All")
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';

// Construct SQL query based on the selected filter
if ($filter === 'All') {
    $sql = "SELECT * FROM membership";
} else {
    $sql = "SELECT * FROM membership WHERE status = :filter";
}

$stmt = $conn->prepare($sql);
if ($filter !== 'All') {
    $stmt->bindParam(':filter', $filter);
}
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle user removal logic
if (isset($_POST['remove'])) {
    if (isset($_POST['user_ids'])) {
        $user_ids = $_POST['user_ids'];
        $query = "DELETE FROM membership WHERE id IN (" . implode(",", array_map('intval', $user_ids)) . ")";
        $stmt = $conn->prepare($query);

        if ($stmt->execute()) {
            echo "<script>alert('Users removed successfully!');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error removing user: " . $stmt->errorInfo()[2];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            
           width: fit-content;
        }
        .card-header {
            background-color: #007BFF;
            color: white;
        }
        .remove-button {
            color: white;
            background-color: red;
        }
        .filter-dropdown {
            width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mt-4">Premium Users Management</h2>
    <a href="dashboard.php" class="btn btn-success mb-3">Back to Dashboard</a>

    <!-- Filter Dropdown -->
    <form method="GET" action="" class="mb-3">
        <select name="filter" class="form-control filter-dropdown" onchange="this.form.submit()">
            <option value="All" <?= $filter === 'All' ? 'selected' : '' ?>>All</option>
            <option value="Approved" <?= $filter === 'Approved' ? 'selected' : '' ?>>Approved</option>
            <option value="Pending" <?= $filter === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Denied" <?= $filter === 'Denied' ? 'selected' : '' ?>>Denied</option>
        </select>
    </form>

    <div class="card">
        <div class="card-header">User List</div>
        <div class="card-body">
            <form method="POST" action="">
                <div>
                    <input type="checkbox" id="select-all"> <label for="select-all">Select All</label>
                </div>

                <?php if (count($users) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Activation Key</th>
                                <th>Machine ID</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="user_ids[]" value="<?= $user['id']; ?>" class="user-checkbox">
                                    </td>
                                    <td><?= $user['id']; ?></td>
                                    <td><?= htmlspecialchars($user['name']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td><?= htmlspecialchars($user['mobile']); ?></td>
                                    <td><?= htmlspecialchars($user['activationKey']); ?></td>
                                    <td><?= htmlspecialchars($user['machineId']); ?></td>
                                    <td><?= htmlspecialchars($user['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="remove" class="btn remove-button">Remove Selected Users</button>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script>
    // Select All Checkbox Functionality
    document.getElementById('select-all').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>

</body>
</html>
