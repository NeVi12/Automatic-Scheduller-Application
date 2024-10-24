<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lecturers</title>
    <link rel="stylesheet" href="css/view_styles.css"> <!-- Link to CSS file -->
</head>
<body>
<button class="top-right-button" onclick="window.location.href='index.php';">
        Main Menu   
</button>

<div class="form-container">
    <h2>Lecturers List</h2>
    
    <table>
        <thead>
            <tr>
                <th>Lecturer Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
    <?php
    include 'db_connect.php'; // Include your DB connection
    $sql = "SELECT lecturers.lecturer_name, lecturers.email, departments.department_name 
            FROM lecturers 
            JOIN departments ON lecturers.dep_id = departments.dep_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td data-label='Lecturer Name'>" . $row['lecturer_name'] . "</td>";
            echo "<td data-label='Email'>" . $row['email'] . "</td>";
            echo "<td data-label='Department'>" . $row['department_name'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No lecturers found</td></tr>";
    }

    $conn->close();
    ?>
</tbody>

    </table>
</div>

</body>
</html>
