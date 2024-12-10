<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Push Notice</title>
    <style>
            
        body {
            margin: 0;
        }
        .main {
            background: 
                radial-gradient(
                    circle, 
                    oklch(0.15 0.2 330 / 0), 
                    oklch(0.15 0.2 330 / 1)
                ),
                linear-gradient(
                    344deg in oklch,
                    oklch(0.3 0.37 310),
                    oklch(0.35 0.37 330),
                    oklch(0.3 0.37 310)
                );
            display: grid;
            height: 100svh;
            place-items: center;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .notice-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .notice-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }
        .notice-form button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body class="main">
    <div class="container">
        <form class="notice-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="notice" placeholder="Enter your notice">
            <button type="submit">Send Notice</button>
            <?php
            if (isset($_POST['notice']) && !empty($_POST['notice'])) {
                echo "<p style='color: green;'>Notice sent successfully.</p>";
            }
            ?>
            <a href="dashboard.php" class="btn-back" style="position: absolute; top: 10px; left: 10px; background-color: yellow; color: Blue; padding: 5px 10px; border-radius: 5px; font-weight: bold;"><i class="fas fa-arrow-circle-left"></i> <strong>Back</strong></a>
            
            
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $notice = $_POST['notice'];
    $json_data = array('msg' => $notice);
    $fp = fopen('notification.json', 'w');
    fwrite($fp, json_encode($json_data));
    fclose($fp);
}

?>