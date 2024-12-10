<?php
// Start the session to access session variables
session_start();

// Destroy the session to log the user out
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect the user to the login page or home page after logout
header("Location: index.php"); // Redirect to home page or login page
exit();
?>
