<?php
include 'db_connect.php';

if (isset($_POST['dep_id'])) {
    $dep_id = $_POST['dep_id'];

    // Fetch courses related to the selected department
    $courses_result = $conn->query("SELECT course_id, course_name FROM courses WHERE dep_id = '$dep_id'");
    $courses = [];
    while ($row = $courses_result->fetch_assoc()) {
        $courses[] = $row;
    }

    // Fetch lecturers related to the selected department
    $lecturers_result = $conn->query("SELECT lec_id, lecturer_name FROM lecturers WHERE dep_id = '$dep_id'");
    $lecturers = [];
    while ($row = $lecturers_result->fetch_assoc()) {
        $lecturers[] = $row;
    }

    // Return the result as JSON
    echo json_encode(['courses' => $courses, 'lecturers' => $lecturers]);
}
?>
