<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rooms</title>
    <link rel="stylesheet" href="css/view_styles.css"> <!-- Link to your CSS file -->
</head>
<body>

<button class="top-right-button" onclick="window.location.href='index.php';">
        Main Menu   
</button>

<div class="form-container">
    <h2>Room List</h2>
    
    <table>
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th>
                <th>Capacity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db_connect.php'; // Include your database connection file
            $sql = "SELECT * FROM rooms";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['room_id'] . "</td>";
                    echo "<td>" . $row['room_name'] . "</td>";
                    echo "<td>" . $row['capacity'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No rooms found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
