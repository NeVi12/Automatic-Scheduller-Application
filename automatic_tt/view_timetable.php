<?php
include 'db_connect.php';

// Fetch timetable data from the database, including time slots
$sql = "SELECT timetable.subject_id, timetable.time_id, timetable.day_of_week, 
               subjects.subject_name, rooms.room_name, lecturers.lecturer_name,
               time_slots.start_time, time_slots.end_time
        FROM timetable
        JOIN subjects ON timetable.subject_id = subjects.subject_id
        JOIN rooms ON timetable.room_id = rooms.room_id
        JOIN lecturers ON timetable.lec_id = lecturers.lec_id
        JOIN time_slots ON timetable.time_id = time_slots.time_id
        ORDER BY timetable.day_of_week, time_slots.start_time";

$result = $conn->query($sql);

// Error handling for query failure
if (!$result) {
    die("SQL Error: " . $conn->error); // Show the actual SQL error
}

// Organize the timetable data by day of the week
$timetable = [
    'monday' => [],
    'tuesday' => [],
    'wednesday' => [],
    'thursday' => [],
    'friday' => []
];

// Fetch time slots dynamically from the database
$time_slots_sql = "SELECT * FROM time_slots ORDER BY start_time";
$time_slots_result = $conn->query($time_slots_sql);
$time_slots = [];
if ($time_slots_result) {
    while ($row = $time_slots_result->fetch_assoc()) {
        $time_slots[] = [
            'time_id' => $row['time_id'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            'formatted' => date("H:i", strtotime($row['start_time'])) . " - " . date("H:i", strtotime($row['end_time']))
        ];
    }
}

// Organizing timetable data by day and time slot
while ($row = $result->fetch_assoc()) {
    $day = strtolower($row['day_of_week']); // Ensure day names are in lowercase
    $timetable[$day][$row['time_id']][] = $row; // Group by time slot
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Timetable</title>
    <link rel="stylesheet" href="css/view_timetable_styles.css"> <!-- Link to CSS file -->
</head>
<body>

<h1>Automated Timetable</h1>

<button class="top-right-button" onclick="window.location.href='index.php';">
        Main Menu   
</button>

<div class="timetable-container">
    <!-- Day Headers -->
    <div class="time-slot"></div> <!-- Empty top-left corner -->
    <div class="day-header">Monday</div>
    <div class="day-header">Tuesday</div>
    <div class="day-header">Wednesday</div>
    <div class="day-header">Thursday</div>
    <div class="day-header">Friday</div>

    <?php 
    $row = 2; // Starting row for the first time slot and subjects

    // Loop through each time slot
    foreach ($time_slots as $slot) {
        // Time slot in the first column (grid column 1)
        echo "<div class='time-slot' style='grid-column: 1; grid-row: {$row};'>{$slot['formatted']}</div>"; 

        // Loop through each day (Monday to Friday)
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $i => $day) {
            $column = $i + 2; // Grid columns start from 2 (Monday), 3 (Tuesday), etc.
            $subject_found = false;

            // Check if there are subjects for the current time slot and day
            if (isset($timetable[$day]) && isset($timetable[$day][$slot['time_id']])) {
                foreach ($timetable[$day][$slot['time_id']] as $subject) {
                    // Place subject in the correct grid column and row
                    echo "<div class='time-slot' style='grid-column: {$column}; grid-row: {$row};'>
                            <div class='subject'>
                                <strong>{$subject['subject_name']}</strong><br>
                                Room: {$subject['room_name']}<br>
                                Lecturer: {$subject['lecturer_name']}
                            </div>
                          </div>";
                    $subject_found = true;
                }
            }

            // If no subject is found, create an empty cell for that time slot and day
            if (!$subject_found) {
                echo "<div class='time-slot' style='grid-column: {$column}; grid-row: {$row};'></div>"; // Empty slot
            }
        }

        // Move to the next row for the next time slot
        $row++;
    }
    ?>
</div>


</body>
</html>
