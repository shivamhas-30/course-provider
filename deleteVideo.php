<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['video_ids'])) {
        $video_ids = implode(',', $_POST['video_ids']);
        $query = "DELETE FROM videos WHERE id IN ($video_ids)";
        if ($conn->query($query)) {
            echo "<script>alert('Videos deleted successfully!'); window.location='deleteVideo.php';</script>";
        } else {
            echo "<script>alert('Error deleting videos.'); window.location='deleteVideo.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Delete Video</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .table {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center; margin-top: 20px;">Delete Video</h1>
    <form method="post">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Video Name</th>
                    <th>Video URL</th>
                    <th>Video Path</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT id, video_name, video_url, video_path FROM videos";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($videos as $video) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name="video_ids[]" value="<?php echo $video['id']; ?>"></td>
                        <td><?php echo $video['video_name']; ?></td>
                        <td><?php echo $video['video_url']; ?></td>
                        <td><?php echo $video['video_path']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Delete Selected</button>
    </form>
</body>

