<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_id = $_POST['time_id'];

    // SQL query to delete the selected time slot
    $sql = "DELETE FROM time_slots WHERE time_id = '$time_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Time slot deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Time Slot</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to CSS file -->
</head>
<body>

<div class="form-container">
    <h2>Delete a Time Slot</h2>
    <form action="delete_time_slot.php" method="POST">
        <label for="time_id">Select Time Slot:</label>
        <select id="time_id" name="time_id" required>
            <!-- Populate options dynamically -->
            <?php
            include 'db_connect.php';
            $result = $conn->query("SELECT time_id, time_slot, start_time, end_time FROM time_slots");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['time_id'] . "'>" . $row['time_slot'] . " (" . $row['start_time'] . " - " . $row['end_time'] . ")</option>";
                }
            } else {
                echo "<option disabled>No time slots available</option>";
            }
            ?>
        </select>

        <input type="submit" value="Delete Time Slot">
    </form>
</div>

</body>
</html>
