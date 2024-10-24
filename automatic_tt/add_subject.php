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
    $subject_name = $_POST['subject_name'];
    $course_id = $_POST['course_id'];
    $dep_id = $_POST['dep_id'];
    $lec_id = $_POST['lec_id']; // Capture lecturer ID

    // Insert subject with associated lecturer
    $sql = "INSERT INTO subjects (subject_name, course_id, lec_id, dep_id) VALUES ('$subject_name', '$course_id', '$lec_id', '$dep_id')";

    if ($conn->query($sql) === TRUE) {
        $message = "New subject added successfully!";
        $success = true;
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add jQuery for making AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<button class="top-right" onclick="window.location.href='view_subjects.php';">
        View Subjects  
</button>

<button class="top-right-button" onclick="window.location.href='index.php';">
        Main Menu   
</button>

<div class="form-container">
    <h2>Add a New Subject</h2>
    <form action="add_subject.php" method="POST">
        <label for="subject_name">Subject Name:</label>
        <input type="text" id="subject_name" name="subject_name" required>

        <label for="dep_id">Department:</label>
        <select id="dep_id" name="dep_id" required onchange="fetchRelatedData()">
            <option value="">Select Department...</option>
            <?php
            include 'db_connect.php';
            $result = $conn->query("SELECT dep_id, department_name FROM departments");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['dep_id'] . "'>" . $row['department_name'] . "</option>";
            }
            ?>
        </select>
        
        <label for="course_id">Course:</label>
        <select id="course_id" name="course_id" required>
            <!-- Courses will be populated dynamically -->
        </select>

        <label for="lec_id">Lecturer:</label>
        <select id="lec_id" name="lec_id" required>
            <!-- Lecturers will be populated dynamically -->
        </select>
        
        <input type="submit" value="Add Subject">
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

<script>
    // Function to fetch courses and lecturers related to the selected department
    function fetchRelatedData() {
        var dep_id = $('#dep_id').val(); // Get selected department ID

        if (dep_id !== '') {
            // Make an AJAX call to get related courses and lecturers
            $.ajax({
                url: 'fetch_related_data.php',
                type: 'POST',
                data: { dep_id: dep_id },
                dataType: 'json',
                success: function(response) {
                    // Populate courses dropdown
                    $('#course_id').empty();
                    $('#course_id').append('<option value="">Select Course...</option>');
                    $.each(response.courses, function(index, course) {
                        $('#course_id').append('<option value="' + course.course_id + '">' + course.course_name + '</option>');
                    });

                    // Populate lecturers dropdown
                    $('#lec_id').empty();
                    $('#lec_id').append('<option value="">Select Lecturer...</option>');
                    $.each(response.lecturers, function(index, lecturer) {
                        $('#lec_id').append('<option value="' + lecturer.lec_id + '">' + lecturer.lecturer_name + '</option>');
                    });
                }
            });
        }
    }
</script>

</body>
</html>
