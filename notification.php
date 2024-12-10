<?php
include('db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
session_start();

if (isset($_POST['action']) && isset($_POST['notification_id'])) {
    $action = $_POST['action'];
    $notification_id = $_POST['notification_id'];

    if ($action == 'approve') {// notification section main approve hone ke baad wala button
        $update_query = "UPDATE membership SET status = 'Approved' WHERE id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':id', $notification_id);
        $stmt->execute();

        $query = "SELECT name, email, productKey FROM membership WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $notification_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $name = $user['name'];
            $email = $user['email'];
            $productKey = $user['productKey'];

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'chandanpatel1230@gmail.com';
                $mail->Password = 'egfb hsqk ulsk woal';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->SMTPDebug = 2;
                $mail->Debugoutput = 'html';
                
                $mail->setFrom('chandanpatel1230@gmail.com', 'Chandan Kumar');
                $mail->addAddress($email);
                
                $mail->isHTML(true);
                $mail->Subject = "Account Approved - Product Key ";
                $message = "Dear $name,\n\nYour account has been approved. Here is your product key: $productKey\n\nThank you!";
                $headers = "From: chandanpatel1230@gmail.com";
                $mail->Body = $message;

                $mail->send();
                echo "<script>
                    alert('Mail sent successfully!');
                    window.location.href = 'notification.php';
                    </script>";
                    
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        }
    } elseif ($action == 'deny') {
        $update_query = "UPDATE membership SET status = 'Denied' WHERE id = :id";
        $stmt = $conn->prepare($update_query);
        $stmt->bindParam(':id', $notification_id);
        $stmt->execute();
    }
}

$query = "SELECT * FROM membership";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: max-content;
            margin: auto;
            background: #fff;
            padding: 20px;
            
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-approve {
            background-color: #28a745;
        }
        .btn-deny {
            background-color: #dc3545;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showConfirmationModal(button) {
            const userId = button.getAttribute('data-id');
            document.getElementById('confirmNotificationId').value = userId;
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Notifications</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Activation Key</th>
                    <th>Machine ID</th>
                    <th>Product Key</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['activationKey'] . "</td>";
                        echo "<td>" . $row['machineId'] . "</td>";
                        echo "<td>" . ($row['productKey'] ?? 'N/A') . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>
                                <button class='btn btn-approve' data-id='" . $row['id'] . "' onclick='showConfirmationModal(this)'>Approve</button>
                                <form method='post' style='display:inline-block;'>
                                    <input type='hidden' name='notification_id' value='" . $row['id'] . "'>
                                    <button type='submit' name='action' value='deny' class='btn btn-deny'>Deny</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No notifications found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn-back">Back to Admin Dashboard</a>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        Are you sure you want to approve this user? This will activate their account and send the product key to their email.
                        <input type="hidden" name="notification_id" id="confirmNotificationId">
                        <input type="hidden" name="action" value="approve">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        setInterval(function() {
        location.reload();
    }, 30000);
    </script>
</body>
</html>

