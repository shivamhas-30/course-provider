<!DOCTYPE html>
<html>
<head>
    <title>Excel File Upload</title>
</head>
<body>
    <!-- File upload form -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="file">Select Excel File:</label>
        <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
        <button type="submit" name="upload">Upload</button>
    </form>

    <?php
    if (isset($_POST['upload'])) {
        // Directory to save the uploaded file
        $uploadDir = 'uploads/';
        
        // Check if the uploads folder exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Get file details
        $fileName = basename($_FILES['file']['name']);
        $targetFilePath = $uploadDir . $fileName;

        // Move uploaded file to the specified folder
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            echo "<p style='color: green;'>File uploaded successfully: $fileName</p>";
        } else {
            echo "<p style='color: red;'>Failed to upload file. Please try again.</p>";
        }
    }
    ?>
</body>
</html>
