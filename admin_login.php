<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the admin is already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php"); // Redirect to dashboard if already logged in
    exit();
}

// Handle login form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];  // Get the input username
    $password = $_POST['password'];  // Get the input password
    
    // Fetch the admin credentials from the database
    $sql = "SELECT * FROM admin WHERE admin_username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Check if any admin record is found
    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password using password_verify (assuming passwords are hashed)
        if (password_verify($password, $admin['admin_password'])) {
            $_SESSION['admin_id'] = $admin['admin_username'];  // Store the admin ID in session
            header("Location: dashboard.php");  // Redirect to the admin dashboard
            exit();
        } else {
            // Invalid password
            $error = "Invalid password!";
        }
    } else {
        // Invalid username
        $error = "Invalid username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes borderAnimation {
            0% { border-color: red; }
            33% { border-color: green; }
            66% { border-color: blue; }
            100% { border-color: red; }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            width: 400px;
            animation: borderAnimation 3s infinite linear;
            border: 6px solid;
        }
        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #000;
        }
        .login-card form {
            display: flex;
            flex-direction: column;
        }
        .login-card label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #fff;
        }
        .login-card input[type="text"],
        .login-card input[type="password"] {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
        }
        .login-card button {
            padding: 15px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        .login-card button:hover {
            background-color: #0056b3;
        }
        .login-card p {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Admin Login</h2>

        <!-- Display error message if credentials are incorrect -->
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>

        <form action="admin_login.php" method="POST">
            <label for="username">Username (Admin ID)</label>
            <input type="text" name="username" required placeholder="Enter admin username">
            
            <label for="password">Password</label>
            <input type="password" name="password" required placeholder="Enter admin password">
            
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>


