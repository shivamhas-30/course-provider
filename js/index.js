// Modal Video Functionality
const modal = document.getElementById("videoModal");
const modalVideo = document.getElementById("modalVideo");
const closeBtn = document.querySelector(".close");

// Open video in modal
document.querySelectorAll('.reel-video').forEach(video => {
    video.addEventListener('click', function() {
        modal.style.display = "flex";
        modalVideo.src = video.src;
        modalVideo.play();
    });
});

// Close video modal
closeBtn.addEventListener('click', function() {
    modal.style.display = "none";
    modalVideo.pause();
    modalVideo.src = "";
});

// Close modal when clicking outside of the video
window.addEventListener('click', function(e) {
    if (e.target === modal) {
        modal.style.display = "none";
        modalVideo.pause();
        modalVideo.src = "";
    }
});



// Show video based on current index
function updateReels() {
    videos.forEach((video, index) => {
        video.style.display = (index === currentIndex) ? 'block' : 'none';
    });
}

nextBtn.addEventListener('click', function() {
    currentIndex = (currentIndex + 1) % videos.length;
    updateReels();
});

prevBtn.addEventListener('click', function() {
    currentIndex = (currentIndex - 1 + videos.length) % videos.length;
    updateReels();
});

// Reels navigation buttons
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const reelsContainer = document.querySelector('.reels-container');

// Function to scroll the reels left (Prev)
prevBtn.addEventListener('click', () => {
    reelsContainer.scrollBy({
        left: -220,  // Adjust scroll amount as needed
        behavior: 'smooth',
    });
});

// Function to scroll the reels right (Next)
nextBtn.addEventListener('click', () => {
    reelsContainer.scrollBy({
        left: 220,  // Adjust scroll amount as needed
        behavior: 'smooth',
    });
});

// Modal (Video Popup) functionality

const closeModal = document.querySelector('.close');

// Function to open the modal and play video
function openModal(videoSrc) {
    modal.style.display = 'flex'; // Show the modal
    modalVideo.src = videoSrc;   // Set the source of the video
    modalVideo.play();            // Auto-play the video
}

// Function to close the modal
function closeVideoModal() {
    modal.style.display = 'none'; // Hide the modal
    modalVideo.pause();           // Pause the video
    modalVideo.currentTime = 0;   // Reset the video to start
}

// Close the modal when clicking on the close button
closeModal.addEventListener('click', closeVideoModal);

// Close the modal when clicking outside of the video
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        closeVideoModal();
    }
});

// Initialize video reel
updateReels();
