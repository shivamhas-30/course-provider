<!DOCTYPE html>
<html>
<head>
    <title>Career Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f7fa;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .submit-btn {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="carrier.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="tel" id="mobile" name="mobile" required>
            </div>
            <div class="form-group">
                <label for="qualification">Qualification:</label>
                <select id="qualification" name="qualification" required>
                    <option value="BCA">BCA</option>
                    <option value="MCA">MCA</option>
                    <option value="MSC">MSC</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="skills">Skills:</label>
            <textarea id="skills" name="skills" rows="3" required placeholder="Enter your skills separated by commas."></textarea>
            </div>
            <div class="form-group">
                <label for="resume">Upload Resume:</label>
                <input type="file" id="resume" name="resume" required>
            </div>
            <button type="submit" class="submit-btn">Send</button>
        </form>
    </div>
</body>
</html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $qualification = $_POST['qualification'];
    $skills = $_POST['skills'];
    $resume = $_FILES['resume']['tmp_name'];
    $resumeName = $_FILES['resume']['name'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'chandanpatel1230@gmail.com';         // Your Gmail address
        $mail->Password = 'egfb hsqk ulsk woal';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('chandanpatel1230@gmail.com', 'Career Registration');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject = 'New Career Registration';

        $mail->Body = "
            <div style='display: flex; flex-direction: column; align-items: center;'>
                <div style='background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; max-width: 400px; width: 100%;'>
                    <h3>New Career Registration Form</h3>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Mobile:</strong> $mobile</p>
                    <p><strong>Qualification:</strong> $qualification</p>
                    <p><strong>Skills:</strong> $skills</p>
                </div>
            </div>
        ";

        $mail->addAttachment($resume, $resumeName);

        $mail->send();
/*************  ✨ Codeium Command 🌟  *************/
        echo "<script>
            alert('Message has been sent. You Will Get A Mail Shortly');
            window.close();
        </script>";
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
