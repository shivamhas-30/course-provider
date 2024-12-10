<?php
// Start session and handle session timeout
session_start();

// Set session timeout duration (1 minute)
$session_timeout = 6000; // in seconds

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

// Fetch user mobile number for activation
$mobile_query = "SELECT mobile_number FROM users WHERE id = :id";
$mobile_stmt = $conn->prepare($mobile_query);
$mobile_stmt->execute([':id' => $_SESSION['user_id']]);
$mobile_number = $mobile_stmt->fetchColumn();

// Fetch membership data to check if the mobile number exists
$membership_query = "SELECT * FROM membership WHERE mobile = :mobile_number";
$membership_stmt = $conn->prepare($membership_query);
$membership_stmt->execute([':mobile_number' => $mobile_number]);
$membership = $membership_stmt->fetch(PDO::FETCH_ASSOC);
echo   $membership['productKey'];


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
            <!-- Account Activation Button -->
            <button class="btn btn-warning" onclick="openActivationModal()">Activate Your Account</button>
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
                    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile_number']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($user['status']); ?></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" onclick="logout()">Logout</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Activation Modal -->
    <div class="modal fade" id="activationModal" tabindex="-1" aria-labelledby="activationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activationModalLabel">Activate Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($membership): ?>
                        <p>Enter your product key:</p>
                        <input type="text" id="productKey" class="form-control" placeholder="Product Key">
                        <div class="modal-footer">
                            

                            <button type="button" class="btn btn-primary" onclick="verifyProductKey()">Verify</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    <?php else: ?>
                        <p></p>Your mobile number is not associated with a premium membership. Please consider subscribing!
                        <a href="subscription.php" class="btn btn-success">Subscribe Now</a></p>
                    <?php endif; ?>
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
            videoElement.src = videoPath;
            videoElement.load();
            modal.show();
        }

        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('modalVideo').src = '';
        });

        function openUserModal() {
            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        }

        function logout() {
            alert("Logging out...");
            window.location.href = "logout.php";
        }

        function openActivationModal() {
            const modal = new bootstrap.Modal(document.getElementById('activationModal'));
            modal.show();
        }

        function verifyProductKey() {
            const productKey = document.getElementById('productKey').value;
            console.log("Product key:", productKey);
            const mobileNumber = '<?php echo $user['mobile_number']; ?>';
            console.log("Mobile number:", mobileNumber);
            
            // Make an AJAX call to verify the product key and update user status
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'verify_product_key.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        alert('Your account has been activated!');
                        window.location.reload(); // Reload page to reflect changes
                    } else {
                        alert('Invalid product key. Please try again.');
                    }
                } else {
                    alert('An error occurred. Please try again later.');
                }
            };
            xhr.send('productKey=' + encodeURIComponent(productKey));
        }

        window.onload = function() {
            startTimer();
        };
    </script>
</body>
</html>
