<?php
include_once 'db.php'; // Include database connection

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Validate the status value (only 'pending' or 'solved')
    if ($status != 'pending' && $status != 'solved') {
        echo "Invalid status.";
        exit;
    }

    // Update the status of the appointment
    $sql = "UPDATE appointments SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Status updated successfully!";
    } else {
        echo "Error updating status.";
    }
}
?>
