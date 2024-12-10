<?php
include 'db.php';

// Fetch videos from the database
$query = "SELECT id, video_name, video_url, video_path FROM videos";
$stmt = $conn->prepare($query);
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle video upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $video_name = $_POST['video_name'];
    $video_path = $_FILES['video_path']['name'];
    $video_url = "uploads/" . $video_path;
    
    // Check for file upload errors
    if (move_uploaded_file($_FILES['video_path']['tmp_name'], $video_url)) {
        $stmt = $conn->prepare("INSERT INTO videos (video_name, video_url, video_path) VALUES (:video_name, :video_url, :video_path)");
        $stmt->bindParam(':video_name', $video_name);
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':video_path', $video_path);
        $stmt->execute();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?success=upload');
        exit();
    } else {
        echo "<script>alert('Error uploading video. Please try again.');</script>";
    }
}

// Handle video deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
    if (!empty($_POST['video_ids'])) {
        $video_ids = implode(',', $_POST['video_ids']);
        $query = "DELETE FROM videos WHERE id IN ($video_ids)";
        if ($conn->query($query)) {
            header('Location: ' . $_SERVER['PHP_SELF'] . '?success=delete');
            exit();
        } else {
            echo "<script>alert('Error deleting videos.');</script>";
        }
    } else {
        echo "<script>alert('No videos selected for deletion!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Video Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

        .container {
            margin-top: 30px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
            align-items: stretch;
        }

        .card {
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            background-color: #f1f1f1;
        }

        .table {
            margin-top: 20px;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
    <main class="main">
        <!-- Back Button -->
        <div class="back-button">
            <a href="dashboard.php" class="btn btn-success">
                &#8592; Back
            </a>
        </div>

        <div class="container">
            <h1 class="text-center" style="color: white;">Video Management</h1>

            <!-- Success Alerts -->
            <?php if (isset($_GET['success']) && $_GET['success'] === 'upload'): ?>
                <div class="alert alert-success">Video uploaded successfully!</div>
            <?php elseif (isset($_GET['success']) && $_GET['success'] === 'delete'): ?>
                <div class="alert alert-success">Videos deleted successfully!</div>
            <?php endif; ?>

            <div class="grid-container">
                <!-- Upload Video -->
                <div class="card">
                    <h4>Upload Video</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">Click Upload Video</button>
                </div>

                <!-- Delete Videos -->
                <div class="card">
                    <h4>Delete Videos</h4>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Click Delete Video</button>
                </div>
            </div>

            <!-- Upload Modal -->
            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload Video</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="video_name">Video Name</label>
                                    <input type="text" class="form-control" id="video_name" name="video_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="video_path">Video File</label>
                                    <input type="file" class="form-control-file" id="video_path" name="video_path" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="upload">Upload</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete Videos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Video Name</th>
                                            <th>Video URL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($videos as $video): ?>
                                            <tr>
                                                <td><input type="checkbox" name="video_ids[]" value="<?php echo $video['id']; ?>"></td>
                                                <td><?php echo htmlspecialchars($video['video_name']); ?></td>
                                                <td><?php echo htmlspecialchars($video['video_url']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-danger" name="delete_selected">Delete Selected</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
