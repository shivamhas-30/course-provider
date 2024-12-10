<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'kandwa';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$mobile_number = $_POST['mobile_number'];
$product_key = $_POST['product_key'];
 echo   $mobile_number;
 echo   $product_key;
 
// Fetch mobile number and product key from the membership table
$stmt = $conn->prepare("SELECT productKey FROM membership WHERE mobile = ?");
$stmt->bind_param("s", $mobile_number);
$stmt->execute();
$stmt->bind_result($valid_key);
$stmt->fetch();
$stmt->close();
// Check if product key is valid (this example assumes the product key is simply a certain string)
if ($product_key === $valid_key) {
    // Update user status to 'active'
    $sql = "UPDATE users SET status = 'Approved' WHERE mobile_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $mobile_number);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Account activated successfully."]);

        $sql = "UPDATE users SET status = 'Approved' WHERE mobile_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $mobile_number);
        $stmt->execute();
        
    } else {
        echo json_encode(["success" => false, "message" => "Error activating account."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid product key."]);
}

// Close connection
$conn->close();
?>
