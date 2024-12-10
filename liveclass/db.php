<?php
// db.php: Establishes connection to the database

$host = 'localhost';       // Your database host (e.g., localhost)
$dbname = 'kandwa';        // Your database name
$username = 'root';        // Your database username
$password = '';            // Your database password (empty if no password is set)

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Uncomment the line below to check if the connection is successful
    // echo "Connected successfully";
} catch (PDOException $e) {
    // If the connection fails, display an error message
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>