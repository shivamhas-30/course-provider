<?php
session_start();
require_once 'db.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_SESSION['email'])) {
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        $email = $_SESSION['email'];

        if ($newPassword == $confirmPassword) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password in the database
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->execute(['password' => $hashedPassword, 'email' => $email]);

            echo "<script>alert('Password has been reset successfully!');</script>";
            header("Location: login.php"); // Redirect to login page
            exit();

            // Clear session data
            unset($_SESSION['otp']);
            unset($_SESSION['email']);
        } else {
            echo "<p>Passwords do not match. Please try again.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Your Password</h2>
        <form action="" method="POST">
            <label for="new_password">Enter New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Re-enter New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>