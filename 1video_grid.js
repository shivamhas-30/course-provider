// Show trial notification on page load
window.onload = function() {
    $('#trialModal').modal('show');
};

// Timer variables
let timer;
let minutes = 10;
let seconds = 0;
const timerDisplay = document.getElementById('timerDisplay');
const startTimerButton = document.getElementById('startTimerButton');

// Start the countdown when the user clicks OK
startTimerButton.addEventListener('click', function() {
    startTimer();
});

// Start the timer countdown
function startTimer() {
    timer = setInterval(function() {
        if (seconds == 0) {
            if (minutes == 0) {
                clearInterval(timer);
                // Show subscription modal when the timer reaches 0
                $('#subscriptionModal').modal('show');
            } else {
                minutes--;
                seconds = 59;
            }
        } else {
            seconds--;
        }

        // Update the timer display
        timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    }, 1000);
}
