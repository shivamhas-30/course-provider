<?php 
include('db.php');
include('activationcode.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Subscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the membership plans */
        .plan-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
            padding: 20px;
            text-align: center;
        }

        .plan-card:hover {
            transform: scale(1.05);
        }

        .card-body ul {
            list-style-type: none;
            padding: 0;
        }

        .card-body ul li {
            padding: 5px 0;
        }

        .card-body h4 {
            color: #28a745;
        }

        .selected {
            border: 2px solid #28a745;
            background-color: #e6f9e6;
        }

        #subscribe-button {
            margin-top: 20px;
        }

        #form-container {
            display: block;
        }

        #payment-container {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="mt-5">Premium Subscription</h1>
        <p>Upgrade to our premium membership for unlimited access to all videos and features!</p>
        
        <!-- Membership Plans -->
        <div class="row">
            <!-- Silver Plan -->
            <div class="col-md-4">
                <div class="card plan-card" id="silver-plan" onclick="selectPlan('silver')">
                    <div class="card-body">
                        <h3>Silver Membership</h3>
                        <h4>&#8377 19.99/month</h4>
                        <ul>
                            <li>Download Videos</li>
                            <li>Save to Playlist</li>
                            <li>Basic Support</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Platinum Plan -->
            <div class="col-md-4">
                <div class="card plan-card" id="platinum-plan" onclick="selectPlan('platinum')">
                    <div class="card-body">
                        <h3>Platinum Membership</h3>
                        <h4>&#8377 29.99/month</h4>
                        <ul>
                            <li>Download Videos</li>
                            <li>Save to Playlist</li>
                            <li>Priority Support</li>
                            <li>Offline Access</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gold Plan -->
            <div class="col-md-4">
                <div class="card plan-card" id="gold-plan" onclick="selectPlan('gold')">
                    <div class="card-body">
                        <h3>Gold Membership</h3>
                        <h4>&#8377 49.99/month</h4>
                        <ul>
                            <li>Download Videos</li>
                            <li>Save to Playlist</li>
                            <li>Premium Support</li>
                            <li>Offline Access</li>
                            <li>Exclusive Content</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Price Section -->
        <div class="mt-4">
            <h3>Total Amount:&#8377<span id="total-price">0.00</span></h3>
        </div>

        <!-- Form for collecting User Details -->
        <div id="form-container">
            <h4>Please enter your details:</h4>
            <form id="user-details-form">
                <div class="mb-3">
                    <label for="user-name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="user-name" required>
                </div>
                <div class="mb-3">
                    <label for="user-mobile" class="form-label">Mobile Number:</label>
                    <input type="tel" class="form-control" id="user-mobile" required>
                </div>
                <div class="mb-3">
                    <label for="user-email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="user-email" required>
                </div>
                <button type="button" class="btn btn-success" onclick="showPaymentDetails()">Next</button>
            </form>
        </div>

        
    </div>

    <!-- JavaScript -->
    <script>
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
            const amount = document.getElementById('total-price').textContent;
            

            // Validate if the fields are filled
            if (name && mobile && email) {
                const data = { name, mobile, email, amount };
                const encryptedData = btoa(JSON.stringify(data));
                const urlParams = new URLSearchParams({ data: encryptedData });
                window.location.href = `payment.php?${urlParams.toString()}`;
                
                
            } else {
                alert("Please fill in all the details.");
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
