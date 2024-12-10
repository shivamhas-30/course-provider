<?php
session_start();
include 'db.php'; // Include the database connection

if (isset($_POST['submit'])) {
    $mobile_no = $_POST['mobile'];
    $password = $_POST['password'];

    // Check if the mobile number exists in the database
    $query = "SELECT * FROM users WHERE mobile_number = :mobile_no";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':mobile_no', $mobile_no);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if ($result) {
        $user = $result[0];
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['mobile_no'] = $user['mobile_number'];
            header("Location: video_grid.php");
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->closeCursor();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Link to the external CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Optional: Link to external JavaScript file -->
    <script src="script.js" defer></script>
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <form action="login.php" method="POST">
        <h3>Login Here</h3>

        <label for="username">Mobile Number</label>
        <input type="text" name="mobile" placeholder="Enter Mobile Number" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter Password" id="password">

        <button type="submit" name="submit">Login</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> <a href="index.php" target="_blank">Home</div>
            <div class="fb"><i class="fab fa-facebook"></i><a href="signup.php" target="_blank"> Create An Account</div>
            <div class="fb"><i class="fab fa-facebook"></i><a href="reset_password.php" target="_blank"> Forget</div>
            <div class="fb"><i class="fab fa-facebook"></i><a href="admin_login.php" target="_blank"> Admin Login</div>
        </div>
    </form>
</body>
</html>