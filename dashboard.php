<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
            padding: 20px;
            background: linear-gradient(to right, #0d69cd, #e60071);

        }
        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
        }
        .grid-item:hover {
            transform: scale(1.05);
        }
        h2 {
            text-align: center;
            color: white;
        }
    </style>
</head>
<body class="main">
    <div>  
    <h2>Admin Dashboard</h2>

    <div class="grid-container">
        <div class="grid-item" onclick="location.href='userview.php'">
            <h3>User View</h3>
            <p>View all users and their details</p>
        </div>
        <div class="grid-item" onclick="location.href='premiumview.php'">
            <h3>Premium View</h3>
            <p>View all premium users and their details</p>
        </div>
        <div class="grid-item" onclick="location.href='managevideo.php'">
            <h3>Manage Videos</h3>
            <p>Manage all videos</p>
        </div>
        <div class="grid-item" onclick="location.href='notification.php'">
            <h3>Notifications</h3>
            <p>View all notifications</p>
        </div>
        <div class="grid-item" onclick="location.href='check_appointments.php'">
            <h3>Check Appointments</h3>
            <p>View and manage all appointments</p>
        </div>
        <div class="grid-item" onclick="location.href='pushNotice.php'">
            <h3>Notices</h3>
            <p>Push Notice On Website</p>
        </div>
        <div class="grid-item" onclick="location.href='UploadFiles1.php'">
            <h3>Downloads</h3>
            <p>Upload Links Or Downlads File</p>
        </div>
        <div class="grid-item" onclick="location.href='Uploadgallery.php'">
            <h3>Gallery</h3>
            <p>Gallery Management  And Photos Upload</p>
        </div>
        <div class="grid-item" onclick="location.href='liveclass.php'">
            <h3>Live Classes</h3>
            <p>Live Classes Management</p>
        </div>
        <div class="grid-item" onclick="location.href='logout.php'">
            <h3>Logout</h3>
            <p>Logout from the admin dashboard</p>
        </div>
    </div>

    

    <script>
        var modal = document.getElementById("myModal");
        var close = document.getElementById("close");

        close.addEventListener("click", function() {
            modal.style.display = "none";
        });

        document.getElementById("show-videos").addEventListener("click", function(event) {
            event.preventDefault();
            modal.style.display = "block";
        });

        document.getElementById("notifications").addEventListener("click", function(event) {
            event.preventDefault();
            window.location.href = "notification.php";
        });
    </script>

</body>
</html>

