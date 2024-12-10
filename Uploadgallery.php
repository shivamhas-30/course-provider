<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "images/gallery/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $msg = "File is not an image.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $msg = "Sorry, your file is too large.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $msg = "Sorry, only JPG, JPEG, PNG files are allowed.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $msg = "Sorry, your file was not uploaded.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $msg = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        } else {
            $msg = "Sorry, there was an error uploading your file.";
            echo '<script type="text/javascript">alert("' . $msg . '");</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <style>
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
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        .upload-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .upload-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .upload-btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="main">
    <a href="dashboard.php" class="back-btn">&larr; Back</a>
    <div class="upload-form">
        <h2>Upload Image</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" required>
            <br>
            <br>
            <input type="submit" class="upload-btn" value="Upload Image" name="submit">
        </form>
    </div>
</body>
</html>

