<?php
// Get all video files from the "reels" directory
$videoFiles = array_diff(scandir('reels'), array('..', '.')); // Exclude '.' and '..' from the list
$videoFiles = array_filter($videoFiles, function($file) {
    // You can filter out non-video files if needed (e.g., .txt, .jpg, etc.)
    return preg_match('/\.(mp4|mov|avi)$/', $file); // Only accept video files (mp4, mov, avi)
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AC Square</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="animatestyle.css">
    <script src="js/index.js" defer></script>
    <style>
        .footer-content {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            background-color: #f9f9f9;
            
        }
        .video-reels {
            width: 70%;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }
        .reels-container {
            display: flex;
            gap: 10px;
        }
        .reel-video {
            width: 200px;
            height: 120px;
            cursor: pointer;
        }
        
        
    </style>
</head>
<body>
        <div style="display: flex; height: 35px;">
            <div style="flex: 0.1; background-color: red; background-color: maroon;">
            <div style="display: flex; justify-content: center; align-items: center;">
                <span style="font-weight: bold; color: white;">Notice: </span>
            </div>
            </div>
            <?php
                $notification = json_decode(file_get_contents('notification.json'), true);
                $message = isset($notification['msg']) ? $notification['msg'] : 'No new notifications';
            ?>
            <marquee style="flex: 1; background-color: maroon; color: white; font-weight: bold; font-size: 1.2rem;" scrollamount="16" behavior="scroll" direction="left" loop="infinite"><?php echo htmlspecialchars($message); ?></marquee>
        </div>
    
        <div style="width: 100%; height: auto; background-color: green; display: flex; justify-content: center; align-items: center;">
        <img src="images/header3.png" alt="AC Square Banner" class="banner-img" style="width: 100%; height: auto; object-fit: cover;">
        </div>
        
    <marquee style="background-color: maroon; color: white; font-weight: bold; font-size: 1.2rem; padding: 10px; border: 1px solid maroon; font-family: 'Arial', sans-serif; " scrollamount="12"">
        Visit our website at <a href="www.mytstechnology.com" style="color: yellow; text-decoration: none;">www.mytstechnology.com</a> | Contact us at +91-999999999 | CBSE | ICSE | State Board | Programming Classes | Addmission For : BCA | B.Com | BBA | BCA | B.Com | BBA | MBA
    </marquee>
    <div style="display: flex; justify-content: center; align-items: center;">
        <a href="appointment.php" class="book-appointment-btn">Book an Appointment</a>
    </div>

    
    <!-- Our Services Section -->
    <section>
        <h2 style="text-align: center; font-size: 2rem; color: #333; margin-bottom: 20px;">Our Services</h2>
        <div class="services-grid">
            <div class="service-item">
                <a href="#">
                    <h3>Web Development</h3>
                </a>
                <p>We create dynamic websites using the latest technologies.</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Software Development</h3>
                </a>
                <p>We build tailored software solutions for your business needs.</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>App Development</h3>
                </a>
                <p>We create mobile apps that offer great user experiences.</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Individual Programming Classes </h3>
                </a>
                <p>C, C++, Java, Python, Web Development, Android, Data Science, Machine Learning ...</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Consulting</h3>
                </a>
                <p>Providing expert advice on digital transformation and technology strategies.</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Schooling </h3>
                </a>
                <p>LKG to Class 8 (Schooling) Available</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Pre Foundation And Foundation Course</h3>
                </a>
                <p>Class 9-12 (Pre Foundation And Foundation Course) Available </p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Addmission In Bachelor And Masters Program</h3>
                </a>
                <p>BTech, BSC, B.Com, BBA, B.Sc. MA, M.Sc., MCA</p>
            </div>
            <div class="service-item">
                <a href="#">
                    <h3>Consulting</h3>
                </a>
                <p>Providing expert advice on digital transformation and technology strategies.</p>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about">
        <h2 style="text-align: center; font-size: 2rem; color: #333; margin-bottom: 20px;">About Us</h2>
            <section id="ac2-services">
            <h2 style="text-align: center; font-size: 2rem; color: #333; margin-bottom: 20px;">AC<sup>2</sup> - Innovating Your Digital World</h2>
            <p style="text-align: center; font-size: 1.1rem; color: #555; line-height: 1.6; font-family: Arial, sans-serif;">
                At AC<sup>2</sup>, we are dedicated to transforming ideas into digital solutions that drive success. 
                With a focus on cutting-edge technologies, our team offers comprehensive services designed to enhance your business and its online presence. 
                Whether you're looking to build a website, develop custom software, or optimize your operations through digital consulting, 
                AC² is here to help you thrive in the digital era.
            </p>
        </section>

    </section><!-- Footer with Horizontal Video Reels -->
<footer style="display: flex; justify-content: center; align-items: center; background-color: green; padding: 10px;">
    <div id="videoReelContainer" class="video-reels" 
        style="
            width: 100%; 
            max-width: 600px; 
            height: 140px; 
            overflow-x: auto; 
            white-space: nowrap; 
            background-color: #fff; 
            border: 2px solid #ccc; 
            border-radius: 10px; 
            padding: 10px; 
            box-sizing: border-box;
            display: flex; /* Ensure the container is treated as a flex container */
        ">
        <!-- Videos will be dynamically loaded here -->
    </div>
</footer>

<!-- Video Popup Modal -->
<div id="videoModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000;">
    <div class="modal-content" style="position: relative; width: 90%; max-width: 600px; aspect-ratio: 16/9; background: #fff; border: 5px solid #000; border-radius: 10px; overflow: hidden;">
        <!-- Close Button -->
        <span class="close" style="position: absolute; right: 10px; top: 10px; z-index: 1; cursor: pointer; font-size: 20px; font-weight: bold; color: red;">&times;</span>
        <!-- Video -->
        <video id="modalVideo" controls style="width: 100%; height: 100%; object-fit: cover;"></video>
    </div>
</div>
    <!-- Reference Links below Footer -->
    <div class="reference-links" style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
    <a href="contact.php" target="_blank" style="margin-right: 10px;">Contact Us </a>
    <a href="carrier.php" target="_blank" style="margin-right: 10px;">Carrier</a>
    <a href="about.php" target="_blank" style="margin-right: 10px;">About Us</a>
    <a href="Downloads.php" target="_blank" style="margin-right: 10px;">Downloads</a>
    <a href="photogallery.php" target="_blank" style="margin-right: 10px;">Gallery</a>
    <a href="login.php" target="_blank" style="margin-right: 10px;">Video Home Page</a>
    <br>
</div>
<div class="footer-text" style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
    &copy; 2023 AC<sup>2</sup> - All Rights Reserved. 
    <a href="privacy.php" target="_blank" style="margin-right: 10px;">Privacy Concerns</a> | 
    <a href="terms.php" target="_blank" style="margin-right: 10px;">Terms and Conditions</a> | 
    Website designed by <a href="https://www.tstechnology.in/" target="_blank">TS Technology</a>
</div>
<script>
      // Fetch videos from the PHP-generated list (replace this with your backend call if needed)
      const videos = [
        <?php
        foreach ($videoFiles as $file) {
            echo "'reels/{$file}',";
        }
        ?>
    ];

    // Variables to manage video loading
    let currentIndex = 0;
    const videosPerLoad = 5; // Number of videos to load at a time

    // Function to load videos into the reel
    function loadVideos() {
        const container = document.getElementById('videoReelContainer');
        const end = Math.min(currentIndex + videosPerLoad, videos.length);

        for (let i = currentIndex; i < end; i++) {
            const videoElement = document.createElement('video');
            videoElement.className = 'reel-video';
            videoElement.src = videos[i];
            videoElement.style.width = '200px';
            videoElement.style.height = '120px';
            videoElement.style.objectFit = 'cover';
            videoElement.style.cursor = 'pointer';
            videoElement.style.marginRight = '10px';

            // Add click event to open the modal
            videoElement.onclick = () => openModal(videos[i]);

            container.appendChild(videoElement);
        }

        currentIndex = end; // Update the current index
    }

    // Lazy load more videos as the user scrolls
    const reelContainer = document.getElementById('videoReelContainer');
    reelContainer.addEventListener('scroll', () => {
        if (
            reelContainer.scrollLeft + reelContainer.clientWidth >=
            reelContainer.scrollWidth - 50
        ) {
            // Load more videos if we reach near the end of the scroll
            loadVideos();
        }
    });

    // Initial load
    loadVideos();

    // Open Modal and Play Video
    function openModal(videoSrc) {
        const modal = document.getElementById('videoModal');
        const modalVideo = document.getElementById('modalVideo');
        modalVideo.src = videoSrc;
        modal.style.display = 'flex'; // Show modal
        modalVideo.play(); // Automatically play video
    }

    // Close Modal
    document.querySelector('.close').addEventListener('click', function () {
        const modal = document.getElementById('videoModal');
        const modalVideo = document.getElementById('modalVideo');
        modal.style.display = 'none'; // Hide modal
        modalVideo.pause(); // Pause video
        modalVideo.src = ''; // Remove video source
    });

    // Close modal when clicking outside the content
    window.addEventListener('click', function (event) {
        const modal = document.getElementById('videoModal');
        if (event.target === modal) {
            const modalVideo = document.getElementById('modalVideo');
            modal.style.display = 'none'; // Hide modal
            modalVideo.pause(); // Pause video
            modalVideo.src = ''; // Remove video source
        }
    });

    // Add an additional style rule to ensure that the scrollbar appears when the content overflows
    window.addEventListener('load', () => {
        const reelContainer = document.getElementById('videoReelContainer');
        // Ensure the scrollbar is triggered by forcing a reflow (may help in some cases)
        reelContainer.style.overflowX = 'auto';
        reelContainer.style.flexWrap = 'nowrap'; // Keep videos in a single row
    });
</script>
</body>
</html>

