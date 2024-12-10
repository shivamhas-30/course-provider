<?php
session_start();
require_once 'db.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['otp']) && isset($_SESSION['otp'])) {
        $enteredOtp = $_POST['otp'];

        if ($enteredOtp == $_SESSION['otp']) {
            // OTP is valid, proceed to change password
            echo "<script>alert('OTP verified successfully!');</script>";
            header("Location: change_password.php"); // Redirect to password change page
            exit();
        } else {
            echo "<p>Incorrect OTP. Please try again.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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

        input[type="text"] {
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
        <h2>Verify OTP</h2>
        <form action="" method="POST">
            <label for="otp">Enter OTP sent to your Email:</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</body>
</html>