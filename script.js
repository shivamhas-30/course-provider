// Function to open video modal and display the video
function openVideoModal(videoElement) {
    // Get the video name and video URL from the clicked element
    const videoName = videoElement.getAttribute('data-video-name');
    const videoUrl = videoElement.querySelector('video source').getAttribute('src');

    // Set the modal title and video source
    document.getElementById('videoTitle').textContent = videoName;
    document.getElementById('modalVideoSource').setAttribute('src', videoUrl);
    const modalVideo = document.getElementById('modalVideo');

    // Load and play the video in the modal
    modalVideo.load();
    modalVideo.play();

    // Show the modal
    document.getElementById('videoModal').style.display = 'block';
}

// Function to close the video modal
function closeModal() {
    // Pause the video and reset the modal
    const modalVideo = document.getElementById('modalVideo');
    modalVideo.pause();
    modalVideo.currentTime = 0; // Reset video to the beginning

    // Hide the modal
    document.getElementById('videoModal').style.display = 'none';
}

// Close modal if clicked outside the modal content
window.onclick = function(event) {
    if (event.target == document.getElementById('videoModal')) {
        closeModal();
    }
}

// scripts.js

// Example JavaScript for form validation
document.querySelector('form').addEventListener('submit', function(event) {
    const mobileInput = document.querySelector('#username');
    const passwordInput = document.querySelector('#password');
    
    if (!mobileInput.value || !passwordInput.value) {
        alert("Please fill in both the mobile number and password fields.");
        event.preventDefault();  // Prevent form submission
    }
});
let userMobile = '';
let generatedOTP = '';

// Function to send OTP
function sendOTP() {
    const mobile = document.getElementById('mobile').value;
    if (!mobile) {
        document.getElementById('mobileError').textContent = 'Please enter a valid mobile number.';
        return;
    }

    fetch('send_otp.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mobile: mobile })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            userMobile = mobile;
            generatedOTP = data.otp; // Save OTP for comparison
            document.getElementById('mobileInput').style.display = 'none';
            document.getElementById('otpInput').style.display = 'block';
            document.getElementById('mobileError').textContent = '';
        } else {
            document.getElementById('mobileError').textContent = data.message;
        }
    });
}

// Function to verify OTP
function verifyOTP() {
    const enteredOTP = document.getElementById('otp').value;
    if (enteredOTP !== generatedOTP) {
        document.getElementById('otpError').textContent = 'Incorrect OTP';
        return;
    }

    document.getElementById('otpInput').style.display = 'none';
    document.getElementById('passwordReset').style.display = 'block';
    document.getElementById('otpError').textContent = '';
}

// Function to reset password
function resetPassword() {
    const newPassword = document.getElementById('newPassword').value;
    if (!newPassword) {
        document.getElementById('passwordError').textContent = 'Please enter a new password.';
        return;
    }

    fetch('reset_password.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ mobile: userMobile, password: newPassword })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            document.getElementById('passwordSuccess').textContent = 'Password has been reset successfully!';
        } else {
            document.getElementById('passwordError').textContent = data.message;
        }
    });
}

// Function to handle plan selection and update the total price
function selectPlan(plan) {
    // Reset all plans to unselected state
    const plans = document.querySelectorAll('.plan-card');
    plans.forEach(plan => plan.classList.remove('selected'));

    // Set the selected plan
    const selectedPlan = document.getElementById(plan + '-plan');
    selectedPlan.classList.add('selected');

    // Update total price and enable subscribe button
    let price = 0;
    switch (plan) {
        case 'silver':
            price = 19.99;
            break;
        case 'platinum':
            price = 29.99;
            break;
        case 'gold':
            price = 49.99;
            break;
    }

    // Update the total amount displayed
    document.getElementById('total-price').textContent = price.toFixed(2);

    // Enable the subscribe button
    document.getElementById('subscribe-button').disabled = false;
}
        // Function to handle plan selection and update the total price
        function selectPlan(plan) {
            // Reset all plans to unselected state
            const plans = document.querySelectorAll('.plan-card');
            plans.forEach(plan => plan.classList.remove('selected'));

            // Set the selected plan
            const selectedPlan = document.getElementById(plan + '-plan');
            selectedPlan.classList.add('selected');

            // Update total price
            let price = 0;
            switch (plan) {
                case 'silver':
                    price = 19.99;
                    break;
                case 'platinum':
                    price = 29.99;
                    break;
                case 'gold':
                    price = 49.99;
                    break;
            }

            // Update the total amount displayed
            document.getElementById('total-price').textContent = price.toFixed(2);
        }

        // Function to show the payment details section after the form is submitted
        function showPaymentDetails() {
            const name = document.getElementById('user-name').value;
            const mobile = document.getElementById('user-mobile').value;
            const email = document.getElementById('user-email').value;

            // Validate if the fields are filled
            if (name && mobile && email) {
                // Hide the form and show the payment details
                document.getElementById('form-container').style.display = 'none';
                document.getElementById('payment-container').style.display = 'block';
            } else {
                alert("Please fill in all the details.");
            }
        }


        function copyToClipboard() {
            const activationKey = document.getElementById('activation-key').innerText;
            const machineId = document.getElementById('machine-id').innerText;
            const textToCopy = `Activation Key: ${activationKey} | Machine ID: ${machineId}`;
            
            navigator.clipboard.writeText(textToCopy).then(function() {
                alert('Copied both Activation Key and Machine ID to clipboard!');
            }).catch(function(err) {
                alert('Error copying text: ' + err);
            });
        }

        // JavaScript function to open WhatsApp chat with pre-filled message
        function openWhatsAppPayment() {
            const name = document.getElementById('user-name') ? document.getElementById('user-name').value : '';
            const mobile = document.getElementById('user-mobile') ? document.getElementById('user-mobile').value : '';
            const email = document.getElementById('user-email') ? document.getElementById('user-email').value : '';
            const amount = document.getElementById('total-price') ? document.getElementById('total-price').textContent : '';
            const message = `Hi, I would like to make a payment for my subscription. My details are: Name - ${name}, Email - ${email}, Mobile Number - ${mobile}. Please transfer the amount of &#8377;${amount} to my UPI ID pankaj343@paytm. Thank you.`;
            const whatsappUrl = `https://wa.me/+91-8957236006?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }