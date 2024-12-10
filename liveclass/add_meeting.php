<?php
include('db.php');  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $start_time = $_POST['start_time'];
    $duration = $_POST['duration'];
    $zoom_meeting_id = $_POST['zoom_meeting_id'];
    $zoom_passcode = $_POST['zoom_passcode'];
    $zoom_link = $_POST['zoom_link'];
    $google_meet_link = $_POST['google_meet_link'];

    // Prepare SQL query
    $sql = "INSERT INTO meetings (title, start_time, duration, zoom_meeting_id, zoom_passcode, zoom_link, google_meet_link)
            VALUES ('$title', '$start_time', '$duration', '$zoom_meeting_id', '$zoom_passcode', '$zoom_link', '$google_meet_link')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "New meeting added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    Title: <input type="text" name="title" required><br>
    Start Time: <input type="datetime-local" name="start_time" required><br>
    Duration (minutes): <input type="number" name="duration" required><br>
    Zoom Meeting ID: <input type="text" name="zoom_meeting_id"><br>
    Zoom Passcode: <input type="text" name="zoom_passcode"><br>
    Zoom Link: <input type="text" name="zoom_link"><br>
    Google Meet Link: <input type="text" name="google_meet_link"><br>
    <input type="submit" value="Add Meeting">
</form>
