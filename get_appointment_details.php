<?php
include_once 'db.php'; // Include database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM appointments WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment) {
        echo json_encode($appointment);
    } else {
        echo json_encode(['error' => 'Appointment not found.']);
    }
}
?>
