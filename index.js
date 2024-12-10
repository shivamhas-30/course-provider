// Modal video logic
function openModal(videoSrc) {
    var modal = document.getElementById('videoModal');
    var modalVideo = document.getElementById('modalVideo');
    modal.style.display = "flex";
    modalVideo.src = videoSrc;
}

document.querySelector('.close').addEventListener('click', function() {
    var modal = document.getElementById('videoModal');
    modal.style.display = "none";
    document.getElementById('modalVideo').src = ""; // Stop the video when closed
});
