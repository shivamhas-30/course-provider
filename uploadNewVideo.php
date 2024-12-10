<?php
include 'db.php';

$query = "SELECT id, video_name, video_url, video_path FROM videos";
$stmt = $conn->prepare($query);
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Upload Video</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .modal {
            display: block;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST['upload'])) {
        $video_name = $_POST['video_name'];
        $video_path = $_FILES['video_path']['name'];
        $video = new SplFileObject($_FILES['video_path']['tmp_name']);
        $video_url = "uploads/" . $video_path;
        $stmt = $conn->prepare("INSERT INTO videos (video_name, video_url, video_path) VALUES (:video_name, :video_url, :video_path)");
        $stmt->bindParam(':video_name', $video_name);
        $stmt->bindParam(':video_url', $video_url);
        $stmt->bindParam(':video_path', $video_path);
        $stmt->execute();
        echo "<script>alert('Video uploaded successfully');</script>";
        move_uploaded_file($_FILES['video_path']['tmp_name'], $video_url);
    }
    ?>
    <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="video_path">Video</label>
                            <input type="file" class="form-control-file" id="video_path" name="video_path" required>
                        </div>
                        <div class="form-group">
                            <label for="video_name">Video Name</label>
                            <input type="text" class="form-control" id="video_name" name="video_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="upload">Upload</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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


