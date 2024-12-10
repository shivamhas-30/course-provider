<?php
include('db.php');

// Fetch all meetings from the database
$sql = "SELECT * FROM meetings ORDER BY start_time ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<b>Title:</b> " . $row["title"] . "<br>";
        echo "<b>Start Time:</b> " . $row["start_time"] . "<br>";
        echo "<b>Duration:</b> " . $row["duration"] . " minutes<br>";
        echo "<b>Zoom Link:</b> <a href='" . $row["zoom_link"] . "'>" . $row["zoom_link"] . "</a><br>";
        echo "<b>Google Meet Link:</b> <a href='" . $row["google_meet_link"] . "'>" . $row["google_meet_link"] . "</a><br>";
        echo "<hr>";
    }
} else {
    echo "No meetings found.";
}
?>
