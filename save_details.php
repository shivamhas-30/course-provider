<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kandwa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$activationKey = $_POST['activationKey'];
$machineId = $_POST['machineId'];
$productKey = $_POST['productKey'];
$msg = "Name: ".$_POST['name']."\nEmail: ".$_POST['email']."\nMobile Number: ".$_POST['mobile']."\nActivation Key: ".$_POST['activationKey']."\nMachine ID: ".$_POST['machineId']."\nProduct Key: ".$_POST['productKey'];

$sql = "INSERT INTO membership (name, mobile, email, activationKey, machineId, productKey) VALUES ('$name', '$mobile', '$email', '$activationKey', '$machineId','$productKey')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    echo "<script>alert('Data saved successfully');</script>";
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
