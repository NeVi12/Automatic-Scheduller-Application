<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: signin.php'); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/welcome_styles.css">
</head>
<body>
    <div class="background-container">
        <div class="clock clock1" id="clock1"></div>
        <div class="clock clock2" id="clock2"></div>
        <div class="clock clock3" id="clock3"></div>
        <div class="clock clock4" id="clock4"></div>
        <div class="loading-circle"></div>
        <div class="loading-circle"></div>
        <div class="loading-circle"></div>
    </div>

    <div class="content-container">
        <h1>Welcome</h1>
        <p>Efficient Time Management Made Easy - Group 28</p>
        <p>Redirecting to the main page shortly...</p>
        <div class="countdown">Redirecting in <span id="countdown">5</span> seconds...</div>
        <button onclick="window.location.href='index.php'">Main Menu</button>
    </div>

    <script>
        // Function to update clocks
        function updateClock(clockElement) {
            const date = new Date();
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const seconds = date.getSeconds();

            // Display the time in HH:MM:SS format
            clockElement.textContent = 
                String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');
        }

        // Function to initialize clocks
        function initClocks() {
            const clock1 = document.getElementById('clock1');
            const clock2 = document.getElementById('clock2');
            const clock3 = document.getElementById('clock3');
            const clock4 = document.getElementById('clock4');

            // Update clocks every second
            setInterval(() => {
                updateClock(clock1);
                updateClock(clock2);
                updateClock(clock3);
                updateClock(clock4);
            }, 1000);

            // Set initial time
            updateClock(clock1);
            updateClock(clock2);
            updateClock(clock3);
            updateClock(clock4);
        }

        // Countdown Timer
        let countdownElement = document.getElementById('countdown');
        let countdown = 5;
        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = 'index.php'; // Redirect to index.php after countdown
            }
        }, 1000); // Update every second

        // Initialize clocks
        initClocks();
    </script>
</body>
</html>
