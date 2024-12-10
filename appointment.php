<?php
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data
        $name = $_POST["name"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $query = $_POST["query"];

        // Validate inputs
        if (empty($name) || empty($date) || empty($time) || empty($query)) {
            die("Error: All fields are required!");
        }
        else{

        
  

        // Prepare SQL statement
        $sql = "INSERT INTO appointments (name,mobile, email, date, time, query) VALUES (:name,:mobile, :email, :date, :time, :query)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
        $stmt->bindParam(':query', $query, PDO::PARAM_STR);
        

        // Execute the query
        $stmt->execute();

        echo "Appointment booked successfully!";
        header("Location: index.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <link rel="stylesheet" href="css/appointment.css">
    <style>
        body {
            background-color: #fff;
        }
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
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .appointment-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(100px, 1fr));
            grid-gap: 1rem;
            margin-top: 20px;
        }
        .form-grid label {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-grid input, .form-grid select, .form-grid textarea {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            width: 100%;
        }
        .submit-btn {
            grid-column: span 2;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body><main class="">
    <div class="container">
        <section class="appointment-form">
            <h2>Book Your Appointment</h2>
            <form action="appointment.php" method="POST">
            <form action="save_appointment.php" method="POST">
                <div class="form-grid">
              
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="mobile">Mobile Number:</label>
                    <input type="tel" id="mobile" name="mobile" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="appointment-date">Appointment Date:</label>
                    <input type="date" id="appointment-date" name="date" required>
                    
                    <label for="appointment-time">AppointmentTime:</label>
                    <input type="time" id="appointment-time" name="time" required>
                    
                    <label for="query">About Your Query:</label>
                    <textarea id="query" name="query" rows="4"></textarea>
                    
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </section>
    </div>
</body>
</html>



