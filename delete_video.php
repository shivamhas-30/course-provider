<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['video_ids'])) {
        $video_ids = implode(',', $_POST['video_ids']);
        $query = "DELETE FROM videos WHERE id IN ($video_ids)";
        if ($conn->query($query)) {
            echo "<script>alert('Videos deleted successfully!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error deleting videos.'); window.location='index.php';</script>";
        }
    } elseif (isset($_POST['video_id'])) {
        $video_id = $_POST['video_id'];
        $query = "DELETE FROM videos WHERE id = $video_id";
        if ($conn->query($query)) {
            echo "<script>alert('Video deleted successfully!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error deleting video.'); window.location='index.php';</script>";
        }
    }
}
?>
