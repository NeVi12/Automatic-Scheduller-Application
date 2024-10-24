<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Time Slots</title>
    <link rel="stylesheet" href="css/view_styles.css"> <!-- Link to CSS file -->
</head>
<body>

<p>
<button class="top-right-button" onclick="window.open('delete_time_slot.php', '_blank');">
    Delete Time Slot
</button>
</p>

<P>
    <button class="top-right" onclick="window.location.href='index.php';">
        Main Menu   
    </button>
</P>



<div class="form-container">
    <h2>Time Slots List</h2>

    <table>
        <thead>
            <tr>
                <th>Time Slot Label</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all time slots from the time_slots table
            $sql = "SELECT * FROM time_slots";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['time_slot'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No time slots found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
