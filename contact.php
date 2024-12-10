<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer files (adjust path if needed)
require 'vendor/autoload.php'; // If you installed via Composer
// Or include the PHPMailer files manually if you downloaded them
// require 'path/to/PHPMailer/PHPMailerAutoload.php'; 

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $query = $_POST['query'];

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                         // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                           // Specify Gmail's SMTP server
        $mail->SMTPAuth = true;                                  // Enable SMTP authentication
        $mail->Username = 'chandanpatel1230@gmail.com';         // Your Gmail address
        $mail->Password = 'egfb hsqk ulsk woal';              // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption
        $mail->Port = 587;                                       // TCP port to connect to (587 is commonly used for TLS)

         // Enable SMTP debugging for troubleshooting
         $mail->SMTPDebug = 2; // Show debugging information
         $mail->Debugoutput = 'html'; // Debug output in HTML format
        //Recipients
        $mail->setFrom('chandanpatel1230@gmail.com', 'Chandan Kumar');
        $mail->addAddress($email);          // Recipient email address

        // Content
        $mail->isHTML(true);                                      // Set email format to HTML
        $mail->Subject = "New Contact Form Submission: " . $subject;
        $mail->Body    = "You have received a new message from the contact form.<br><br>" .
                         "<strong>Name:</strong> " . $name . "<br>" .
                         "<strong>Email:</strong> " . $email . "<br>" .
                         "<strong>Subject:</strong> " . $subject . "<br>" .
                         "<strong>Query:</strong> " . nl2br($query);

        // Send the email
        $mail->send();
        echo "<script>alert('Thank you for your message! We will get back to you shortly.');</script>";
        
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
    echo "<script>window.location.href = window.location.href;</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .contact-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .contact-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .contact-form label {
            font-size: 14px;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        .contact-form textarea {
            resize: vertical;
            height: 120px;
        }
        .contact-form button {
            background-color: #007BFF;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .contact-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="contact-form">
        <h2>Contact Us</h2>
        <form action="contact.php" method="POST">
            <label for="name">Your Name</label>
            <input type="text" name="name" required placeholder="Enter your name">
            
            <label for="email">Your Email</label>
            <input type="email" name="email" required placeholder="Enter your email">
            
            <label for="subject">Subject</label>
            <input type="text" name="subject" required placeholder="Subject of your query">
            
            <label for="query">Query</label>
            <textarea name="query" required placeholder="Enter your message or query"></textarea>
            
            <button type="submit" name="send">Send</button>
        </form>
    </div>
</body>
</html>
