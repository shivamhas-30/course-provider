<?php
include 'db.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf'])) {
    $targetDir = "docs/";
    $fileName = basename($_FILES["pdf"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    
    if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $targetFilePath)) {
        $datetime = date('Y-m-d h:i:s A');
        
        $stmt = $conn->prepare("INSERT INTO downloads (datetime, FileName, FileSave) VALUES (?, ?, ?)");
        $stmt->execute([$datetime, $fileName, $targetFilePath]);
        
        $msg = "The file " . htmlspecialchars($fileName) . " has been uploaded successfully.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
    } else {
        $msg = "Sorry, there was an error uploading your file.";
        echo '<script type="text/javascript">alert("' . $msg . '");</script>';
    }
}

if (isset($_POST['delete'])) {
    $fileId = $_POST['file_id'];
    
    // Fetch the file path to delete from the filesystem
    $stmt = $conn->prepare("SELECT FileSave FROM downloads WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch();

    if ($file && file_exists($file['FileSave'])) {
        unlink($file['FileSave']); // Delete the file from the filesystem
    }
    
    // Delete the file record from the database
    $stmt = $conn->prepare("DELETE FROM downloads WHERE id = ?");
    $stmt->execute([$fileId]);

    // Reload the page after deletion
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Manage PDFs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        
        .main {
            background: radial-gradient(circle, oklch(0.15 0.2 330 / 0), oklch(0.15 0.2 330 / 1)), linear-gradient(344deg in oklch, oklch(0.3 0.37 310), oklch(0.35 0.37 330), oklch(0.3 0.37 310));
            display: grid;
            height: 100svh;
            place-items: center;
        }
        
        .upload-form {
            margin: 20px auto;
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        label {
            display: block;
        }
        
        input[type="file"] {
            margin-bottom: 10px;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .table-container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn {
            color: white;
            background: red;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: darkred;
        }

        .back-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: green;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .back-btn:hover {
            background: darkgreen;
        }
    </style>
</head>
<body class="main">
    <button class="back-btn" onclick="window.location.href='dashboard.php'">Back</button>
    <form class="upload-form" action="" method="post" enctype="multipart/form-data">
        <label for="pdf">Choose PDF to upload:</label>
        <input type="file" name="pdf" id="pdf" accept=".pdf" required>
        <input type="submit" value="Upload PDF">
    </form>

    <div class="table-container">
        <h2>Uploaded Files</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>File Name</th>
                    <th>Uploaded On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM downloads ORDER BY id DESC");
                while ($row = $stmt->fetch()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['FileName']}</td>
                            <td>{$row['datetime']}</td>
                            <td>
                                <form method='post' style='display: inline;'>
                                    <input type='hidden' name='file_id' value='{$row['id']}'>
                                    <button type='submit' name='delete' class='delete-btn'>Remove</button>
                                </form>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

