<?php
include('db.php');
include('activationcode.php');
$getKey = generateActivationKey();

if (isset($_GET['data'])) {
    $encryptedData = $_GET['data'];
    $data = json_decode(base64_decode($encryptedData), true);
    $name = $data['name'];
    $mobile = $data['mobile'];
    $email = $data['email'];
    $amount = $data['amount'];
    $activationKey = $getKey['activationKey'];
    $machineId = $getKey['machineId'];
    $productKey = $getKey['productKey'];
} else {
    header("Location: subscription.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        #payment-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h4 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        .copy-icon {
            cursor: pointer;
            font-size: 16px;
            color: #007bff;
        }

        .copy-icon:hover {
            text-decoration: underline;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .card-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 100%;
            max-width: 350px;
            text-align: left;
        }

        .card p {
            font-size: 14px;
            margin: 10px 0;
        }

        .card .copy-icon {
            display: inline-block;
            margin-left: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .qr-container {
            margin: 20px 0;
        }

        .advice-message {
            font-style: italic;
            color: #555;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>

    <!-- Payment Details Section -->
    <div id="payment-container">
        <h4>Payment Details</h4>
        <p><strong>Your UPI ID:</strong> pankaj343@paytm</p>
        <p><strong>WhatsApp Number:</strong> 8957236006</p>

        <div class="qr-container">
            <p><strong>QR Code:</strong></p>
            <img src="images/qr.jpg" alt="QR Code" style="width: auto; height: 150px;">
        </div>

        <!-- Card Container for Activation Key and Machine ID -->
        <div class="card-container">
            <div class="card">
                <p><strong>Activation Details:</strong>
                    <p>Activation Key: <?php echo $activationKey; ?></p>
                    <p>Machine Id: <?php echo $machineId; ?></p>
                </p>
            </div>
        </div>

        <!-- Advice Message -->
        <p class="advice-message"><strong>Advice:</strong> Please send a screenshot of this page with the Activation Key and Machine ID along with your payment details on WhatsApp. And Dowload the Payment Details PDF.</p>

        <button type="button" onclick="openWhatsApp()">Open WhatsApp</button>
        <button type="button" onclick="downloadpdf()">Download PDF</button>

        <script>
            function downloadpdf() {
                // Access jsPDF from the global object (window)
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                doc.text(`Name: <?php echo $name; ?>`, 10, 10);
                doc.text(`Email: <?php echo $email; ?>`, 10, 20);
                doc.text(`Mobile Number: <?php echo $mobile; ?>`, 10, 30);
                doc.text(`Amount: <?php echo "₹" . $amount; ?>`, 10, 40);
                doc.text(`Activation Key: <?php echo $activationKey; ?>`, 10, 50);
                doc.text(`Machine ID: <?php echo $machineId; ?>`, 10, 60);
                
                var pdfName = 'payment_details.pdf';
                doc.save(pdfName);  // Save the PDF with the specified name
            }

            function openWhatsApp() {
                const name = "<?php echo $name; ?>";
                const mobile = "<?php echo $mobile; ?>";
                const email = "<?php echo $email; ?>";
                const amount = "<?php echo $amount; ?>";
                const activation_key = "<?php echo $activationKey; ?>";
                const machine_id = "<?php echo $machineId; ?>";
                const productKey = "<?php echo $productKey; ?>";

                const data = new FormData();
                data.append('name', name);
                data.append('mobile', mobile);
                data.append('email', email);
                data.append('amount', amount);
                data.append('activationKey', activation_key);
                data.append('machineId', machine_id);
                data.append('productKey', productKey);

                fetch('save_details.php', {
                    method: 'POST',
                    body: data
                }).then(response => response.text())
                .then(data => {
                    console.log(data);
                    alert('Data has been saved successfully');
                    window.close();
                    
                }).catch(error => {
                    console.error('Error:', error);
                    alert('There was an error saving the data');
                });

                const msg = `Hi, I made a payment for my subscription on your website.\n` +
                            `My details are:\n` +
                            `Name - ${name}\n` +
                            `Email - ${email}\n` +
                            `Mobile Number - ${mobile}\n` +
                            `I have transferred the amount of ₹${amount} to my UPI ID pankaj343@paytm.\n` +
                            `Thank you.\n` +
                            `My Activation Key and Machine ID are:\n` +
                            `Activation Key: ${activation_key}\n` +
                            `Machine ID: ${machine_id}`;
                const url = `https://wa.me/+918957236006?text=${encodeURIComponent(msg)}`;
                window.open(url, '_blank');

            }
        </script>
    </div>

</body>
</html>
