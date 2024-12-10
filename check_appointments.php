<?php
// Start session and include database connection
session_start();
require_once 'db.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Initialize the appointments variable
$appointments = [];

// Get filter value from the request (default to "All")
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';

try {
    // Construct SQL query based on the selected filter
    if ($filter === 'All') {
        $sql = "SELECT * FROM appointments";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "SELECT * FROM appointments WHERE status = :filter";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':filter', $filter);
    }

    // Execute the query and fetch results
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Log the number of fetched appointments
    error_log("Fetched " . count($appointments) . " appointments.");
} catch (PDOException $e) {
    // Handle database errors
    error_log("Database error: " . $e->getMessage());
    echo "<p>Error fetching appointments. Please try again later.</p>";
}

// Handle status update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];

    // Debugging: Log the inputs
    error_log("Received User ID: $user_id, New Status: $new_status");

    if (!empty($user_id) && in_array($new_status, ['Pending', 'Approved'])) {
        try {
            $query = "UPDATE appointments SET status = :new_status WHERE id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':new_status', $new_status);
            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                // Debugging: Log successful update
                error_log("Status updated for User ID: $user_id to $new_status");

                // Refresh the page to fetch updated data
                header("Location: check_appointments.php?filter=$filter");
                exit();
            } else {
                error_log("Failed to update status for User ID: $user_id");
                echo "<p>Error updating status. Please try again.</p>";
            }
        } catch (PDOException $e) {
            error_log("Database error during update: " . $e->getMessage());
            echo "<p>Error updating status. Please try again later.</p>";
        }
    } else {
        echo "<script>alert('Invalid input data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
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
        .approved-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .pending-button {
            background-color: yellow;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .filter-dropdown {
            width: 200px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mt-4">Appointment Management</h2>
    <a href="dashboard.php" class="btn btn-success mb-3">Back to Dashboard</a>

    <!-- Filter Dropdown -->
    <form method="GET" action="" class="mb-3">
        <select name="filter" class="form-control filter-dropdown" onchange="this.form.submit()">
            <option value="All" <?= $filter === 'All' ? 'selected' : '' ?>>All</option>
            <option value="Approved" <?= $filter === 'Approved' ? 'selected' : '' ?>>Approved</option>
            <option value="Pending" <?= $filter === 'Pending' ? 'selected' : '' ?>>Pending</option>
        </select>
    </form>

    <div class="card">
        <div class="card-header">Appointments</div>
        <div class="card-body">
            <?php if (count($appointments) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['id']); ?></td>
                                <td><?= htmlspecialchars($appointment['name']); ?></td>
                                <td><?= htmlspecialchars($appointment['email']); ?></td>
                                <td><?= htmlspecialchars($appointment['mobile']); ?></td>
                                <td><?= htmlspecialchars($appointment['date']); ?></td>
                                <td><?= htmlspecialchars($appointment['time']); ?></td>
                                <td><?= htmlspecialchars($appointment['status']); ?></td>
                                <td>
                                    <form method="POST" action="" style="display: inline-block;">
                                        <input type="hidden" name="user_id" value="<?= $appointment['id']; ?>">
                                        <input type="hidden" name="new_status" value="Approved">
                                        <button type="submit" name="update_status" class="approved-button">Mark as Approved</button>
                                    </form>
                                    <form method="POST" action="" style="display: inline-block;">
                                        <input type="hidden" name="user_id" value="<?= $appointment['id']; ?>">
                                        <input type="hidden" name="new_status" value="Pending">
                                        <button type="submit" name="update_status" class="pending-button">Mark as Pending</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No appointments found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
