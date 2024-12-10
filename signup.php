<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer files (adjust path if needed)
require 'vendor/autoload.php'; // If you installed via Composer
// Or include the PHPMailer files manually if you downloaded them
// require 'path/to/PHPMailer/PHPMailerAutoload.php'; 
include 'db.php'; // Ensure you include your DB connection file

if (isset($_POST['submit'])) {
    $name=$_POST['name'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $query = "INSERT INTO users (name, email, mobile_number, password) VALUES (:name, :email, :mobile_no, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':mobile_no', $mobile_no, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Registration successful! ";
        
        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                         // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                           // Specify Gmail's SMTP server
            $mail->SMTPAuth = true;                                  // Enable SMTP authentication
            $mail->Username = 'chandanpatel1230@gmail.com';         // Your Gmail address
            $mail->Password = 'egfb hsqk ulsk woal';                // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption
            $mail->Port = 587;                                       // TCP port to connect to (587 is commonly used for TLS)

            // Enable SMTP debugging for troubleshooting
            $mail->SMTPDebug = 2; // Show debugging information
            $mail->Debugoutput = 'html'; // Debug output in HTML format
            
            // Recipients
            $mail->setFrom('chandanpatel1230@gmail.com', 'Chandan Kumar');
            $mail->addAddress($email);          // Recipient email address

            // Content
            $mail->isHTML(true);                                      // Set email format to HTML
            $mail->Subject = "You Registration Successfully Done!: " . $subject;
            $mail->Body    = "You have received a new message from the ACC. Your Login Details As Per Follows<br><br>" .
                             "<strong>Login Id:</strong> " . $mobile_no . "<br>" .
                             "<strong>Password:</strong> " . $password . "<br>" .
                             "<strong>Query:</strong> " . nl2br("Thank You");

            // Send the email
            $mail->send();
            echo "<script>
                alert('Thank you for your registration! Your Login Id and Password have been sent to your email.');
                window.location.href = 'login.php';
                window.close();  // Close the current window
            </script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer' Error: {$mail->ErrorInfo}');</script>";
        }

        // Close the database statement

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V15</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->    
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->    
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->    
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
                    <span class="login100-form-title-1">
                        Register Yourself
                    </span>
                </div>

                <form class="login100-form validate-form" action="signup.php" method="POST">
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Name is required">
                        <span class="label-input100">Name</span>
                        <input class="input100" type="text" name="name" placeholder="Enter Name">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                        <span class="label-input100">Email-Id</span>
                        <input class="input100" type="text" name="email" placeholder="Enter Email">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-26" data-validate="Mobile Number is required">
                        <span class="label-input100">Mobile Number</span>
                        <input class="input100" type="text" name="mobile" placeholder="Enter Mobile Number">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password" placeholder="Enter password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="flex-sb-m w-full p-b-30">
                        <div>
                            <a href="reset_password.php" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="submit">
                            Sign Up
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>
