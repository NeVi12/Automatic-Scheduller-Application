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

include 'db_connect.php';

$message = ''; // Initialize a message variable
$success = false; // To track whether the operation was successful

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_slot = $_POST['time_slot'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO time_slots (time_slot, start_time, end_time) VALUES ('$time_slot', '$start_time', '$end_time')";

    if ($conn->query($sql) === TRUE) {
        $message ="New time slot added successfully";
        $success = true;
    } else {
        $message ="Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Time Slot</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<button class="top-right" onclick="window.location.href='view_time_slots.php';">
        View Time Slots 
</button>
<button class="top-right-button" onclick="window.location.href='index.php';">
        Main Menu   
</button>

<div class="form-container">
    <h2>Add Time Slots</h2>
    <form action="add_time_slot.php" method="POST">
        <label for="time_slot">Time Slot Label:</label>
        <input type="text" id="time_slot" name="time_slot" placeholder="e.g., Slot 1, Morning" required>
        
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required>
        
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required>
        
        <input type="submit" value="Add Time Slot">
    </form>
</div>

<!-- Modal for showing the message -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $success ? 'Success' : 'Error'; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo $message; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS for modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Show the modal if there's a message
    <?php if ($message != ''): ?>
    var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    messageModal.show();
    <?php endif; ?>
</script>

</body>
</html>
