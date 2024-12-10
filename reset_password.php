<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'db.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Verify the email exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Email exists, generate OTP and send it via email
            $otp = rand(1000, 9999); // 4-digit OTP

            // Save the OTP in session for later validation
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Use PHPMailer to send OTP via email
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'chandanpatel1230@gmail.com';
                $mail->Password = 'egfb hsqk ulsk woal';   
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('chandanpatel1230@gmail.com', 'Password Reset');
                $mail->addAddress($email); // Recipient's email
                $mail->Subject = 'Your OTP for Password Reset';
                $mail->Body = "Your OTP for password reset is: $otp";

                if ($mail->send()) {
                    echo "<p>OTP sent to your email. Please check your inbox.</p>";
                    header("Location: verify_otp.php"); // Redirect to OTP verification page
                    exit();
                } else {
                    echo "<p>Error sending OTP: " . $mail->ErrorInfo . "</p>";
                }
            } catch (Exception $e) {
                echo "<p>Error sending OTP: " . $e->getMessage() . "</p>";
            }
        } else {

                echo "<script>alert('Email not found in database.');</script>";


        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
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

        input[type="email"] {
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

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 200px;
            height: 200px;
            border-radius: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <h2>Forgot Password</h2>
        <form action="" method="POST">
            <label for="email">Enter your Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send OTP</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>