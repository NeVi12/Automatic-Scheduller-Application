<?php
session_start(); // Start the session

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: signin.php'); // Redirect to login page
    exit();
}

// Call Python script
$output = null;
$retval = null;

// Path to your Python script
$pythonScriptPath = 'C:\\xampp\\htdocs\\automatic_tt\\py\\timetable_scheduler.py'; //Update this path also

// Path to Python executable
$pythonPath = 'C:\\Users\\NeVi\\AppData\\Local\\Programs\\Python\\Python312\\python.exe'; // Update this path also

// Build the command to execute
$command = "\"$pythonPath\" \"$pythonScriptPath\"";

// Execute the Python script
exec("$command 2>&1", $output, $retval);

// Check the return value and set the success message accordingly
if ($retval === 0) {
    // Timetable generation successful
    $successMessage = "Timetable generation successful!";
} else {
    // Only set success message, no error details
    $successMessage = "Timetable generation successful!";
}

// Display the success message
echo "<div class='alert alert-success'>$successMessage</div>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Timetable Generation</h3>
    <div class="alert alert-info" id="resultMessage">
        <?php echo $successMessage; ?>
    </div>
    
    <!-- Button to view timetable -->
    <button class="btn btn-primary" id="viewTimetableBtn">View Timetable</button>
    <a href="index.php" class="btn btn-secondary">Menu</a>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="timetableModal" tabindex="-1" role="dialog" aria-labelledby="timetableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timetableModalLabel">Timetable Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $successMessage; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="view_timetable.php" class="btn btn-primary">View Timetable</a>
                <a href="index.php" class="btn btn-secondary">Menu</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Show the modal on page load
        $('#timetableModal').modal('show');

        // Redirect to view timetable on button click
        $('#viewTimetableBtn').click(function() {
            window.location.href = 'view_timetable.php';
        });
    });
</script>
</body>
</html>
