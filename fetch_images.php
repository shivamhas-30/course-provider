<?php
header('Content-Type: application/json');

// Directory containing images
$directory = "images/gallery/";

// Fetch all image files from the directory
$files = glob($directory . "*.*");

// Return the list of image paths as a JSON array
echo json_encode($files);
?>
