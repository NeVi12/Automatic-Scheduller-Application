<?php
session_start(); // Start the session

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: signin.php'); // Redirect to login page
    exit(); // Ensure no further code is executed
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'automatic_tt');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/index_styles.css">

    <style>
        /* Loading Screen Styles */
        .loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            text-align: center;
            padding-top: 150px;
        }

        .loading-screen h2 {
            margin-bottom: 20px;
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border-left-color: #4285f4;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<header>
    <h1>Automatic Time Table Scheduling Web App</h1>
</header>

<nav>
    <div class="dropdown">
        <a href="#" class="dropbtn">
            <i class="fas fa-chalkboard-teacher"></i> Manage Lecturers
        </a>
        <div class="dropdown-content">
            <a href="add_lecturer.php">Add New Lecturer</a>
            <a href="view_lecturers.php">View Lecturers</a>
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="dropbtn">
            <i class="fas fa-book"></i> Manage Subjects
        </a>
        <div class="dropdown-content">
            <a href="add_subject.php">Add New Subject</a>
            <a href="view_subjects.php">View Subjects</a>
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="dropbtn">
            <i class="fas fa-building"></i> Manage Rooms
        </a>
        <div class="dropdown-content">
            <a href="add_room.php">Add New Room</a>
            <a href="view_rooms.php">View Rooms</a>
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="dropbtn">
            <i class="fas fa-clock"></i> Manage Time Slots
        </a>
        <div class="dropdown-content">
            <a href="add_time_slot.php">Add New Time Slot</a>
            <a href="view_time_slots.php">View Time Slots</a>
        </div>
    </div>

    
    <a href="view_timetable.php">
        <i class="fas fa-calendar-alt"></i> View Time Table
    </a>
   
    <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i> Log Out
    </a>
</nav>



<div class="container">
    <!-- Button for generating timetable -->
    <button class="btn btn-primary" id="generate-timetable-btn">Generate Timetable</button>

    <div class="card">
        <h3>Welcome to the Automatic Time Table Scheduling Web App </h3>
        <p>This platform is designed to streamline the scheduling process for educational institutions. Administrators can manage courses, subjects, rooms, lecturers, and departments, making timetable generation seamless.</p>
        <p>Group 28 Team Members :</p>
        <p>
        H.G.SERAN NELAKA 21UG1031 <br>
        W.A.RAVEESHA SANJU LAKSHAN 21UG1014 <br>
        S.TANUKA SHASHIPRABATH 21UG0990 <br>
        VINURA WIJAYAGUNATHILAKE 21UG1089 <br>
        K.GOBISHAN 21UG1020 <br>
        </p>
    </div>

    <!-- Loading screen overlay -->
    <div class="loading-screen" id="loading-screen">
        <div class="spinner"></div>
        <h2 id="loading-text">Loading lecturers...</h2>
    </div>
</div>

<footer>
    <p>&copy; 2024 Automatic Time Table Scheduling Web App by Group 28</p>
    <p><a href="terms.php">Terms of Service</a> | <a href="privacy.php">Privacy Policy</a> | <a href="mailto:serannelaka@gmail.com?subject=Inquiry&body=Hello,%20I%20have%20a%20question%20about%20your%20service.">Contact Developer</a></p>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('generate-timetable-btn').addEventListener('click', function() {
    // Show the loading screen
    document.getElementById('loading-screen').style.display = 'block';

    // Simulate loading steps
    let steps = ['Loading lecturers...', 'Loading subjects...', 'Loading rooms...', 'Checking lecturer availability...', 'Finalizing timetable...'];
    let index = 0;

    let loadingText = document.getElementById('loading-text');
    let interval = setInterval(function() {
        if (index < steps.length) {
            loadingText.textContent = steps[index];
            index++;
        } else {
            clearInterval(interval);
            // After loading steps, redirect to generate_timetable.php
            window.location.href = 'generate_timetable.php';
        }
    }, 1000); // Each step shows for 1 second
});
</script>

</body>
</html>
