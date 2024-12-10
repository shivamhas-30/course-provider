<?php
// Start session and handle session timeout
session_start();

// Set session timeout duration (1 minute)
$session_timeout = 60; // in seconds

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    session_unset();     // Unset session variables
    session_destroy();   // Destroy session
    echo "<script>window.location.href = 'logout.php';</script>";  // Redirect to logout page
}
$_SESSION['last_activity'] = time();  // Update last activity time

// Database connection
require_once 'db.php'; // Ensure this file has the connection details for your database

// Fetch video data from the database
try {
    $query = "SELECT * FROM videos"; // Adjust the table name as per your database schema
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Debugging: Output number of rows fetched
    if ($result->rowCount() == 0) {
        echo "<p>No videos found in the database.</p>";
    }
} catch (Exception $e) {
    echo "<p>Error fetching videos: " . $e->getMessage() . "</p>";
    $result = null; // Set $result to null to prevent further errors
}

// Fetch logged-in user data
$query = "SELECT * FROM users WHERE id = :id"; // Adjust this query as needed
$stmt = $conn->prepare($query);
$stmt->execute([':id' => $_SESSION['user_id']]); // Assuming you store user id in session
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Navbar Style */
        nav {
            background-color: #007bff;
            padding: 10px 20px;
            position: relative;
        }

        nav .navbar-brand {
            color: white;
        }

        /* User Icon Style */
        .user-icon {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 18px;
            color: white;
            cursor: pointer;
        }

        /* Timer Style */
        #timer {
            position: absolute;
            top: 40px;
            left: 20px;
            font-size: 20px;
            color: red;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .video-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            cursor: pointer;
        }

        .video-title {
            margin: 10px 0;
            font-size: 14px;
            font-weight: bold;
        }

        /* Styling for the modal video container */
        .video-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 400px; /* Fixed height */
            overflow: hidden;
            background-color: black; /* Optional: Add a background for better aesthetics */
        }

        .modal-video {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Ensures video scales proportionally */
            border-radius: 8px; /* Optional: Adds rounded corners */
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Video Gallery</a>
        <!-- User Icon -->
        <?php if (isset($user)): ?>
            <div class="user-icon" id="userIcon" onclick="openUserModal()">
                <i class="bi bi-person-circle"></i>
            </div>
        <?php endif; ?>
    </nav>

    <!-- Timer -->
    <div id="timer">01:00</div>

    <h1 style="text-align: center; margin-top: 20px;">Video Gallery</h1>

    <!-- Video Gallery -->
    <div class="grid-container">
        <?php if ($result && $result->rowCount() > 0): ?>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="video-card" onclick="openModal('<?php echo htmlspecialchars($row['video_url']); ?>')">
                    <div class="video-title"><?php echo htmlspecialchars($row['video_name']); ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No videos found in the database.</p>
        <?php endif; ?>
    </div>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="video-container">
                        <video class="modal-video" id="modalVideo" controls></video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($user['status']); ?></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onclick="logout()">Logout</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let timerValue = 60; // 1 minute timer
        let timerInterval;

        function updateTimer() {
            let minutes = Math.floor(timerValue / 60);
            let seconds = timerValue % 60;
            document.getElementById('timer').textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            
            if (timerValue <= 0) {
                clearInterval(timerInterval);
                alert("Session expired! Please log in again.");
                window.location.href = 'logout.php';
            } else {
                timerValue--;
            }
        }

        function startTimer() {
            timerInterval = setInterval(updateTimer, 1000);
        }

        function openModal(videoPath) {
            const modal = new bootstrap.Modal(document.getElementById('videoModal'));
            const videoElement = document.getElementById('modalVideo');

            console.log("Loading video:", videoPath); // Debugging log

            videoElement.src = videoPath; // Set video source
            videoElement.load(); // Load video
            modal.show(); // Show modal
        }

        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('modalVideo').src = ''; // Clear video source
        });

        function openUserModal() {
            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        }

        function logout() {
            alert("Logging out...");
            window.location.href = "logout.php";
        }

        window.onload = function() {
            startTimer();
        };
    </script>
</body>
</html>
