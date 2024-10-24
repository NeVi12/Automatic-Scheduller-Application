<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subjects</title>
    <link rel="stylesheet" href="css/view_styles.css"> <!-- Link to CSS file -->
</head>
<body>

<button class="top-right-button" onclick="window.location.href='index.php';">
        Main Menu   
</button>

<div class="form-container">
    <h2>Subjects List</h2>
    
    <table>
        <thead>
            <tr>
                <th>Subject Name</th>
                <th>Course</th>
                <th>Lecturer</th> <!-- New Lecturer column -->
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db_connect.php'; // Include your DB connection

            // Updated SQL query to include lecturer's name
            $sql = "SELECT subjects.subject_name, courses.course_name, departments.department_name, lecturers.lecturer_name 
                    FROM subjects 
                    JOIN courses ON subjects.course_id = courses.course_id
                    JOIN departments ON subjects.dep_id = departments.dep_id
                    JOIN lecturers ON subjects.lec_id = lecturers.lec_id"; // Join lecturers table

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['subject_name'] . "</td>";
                    echo "<td>" . $row['course_name'] . "</td>";
                    echo "<td>" . $row['lecturer_name'] . "</td>"; // Display lecturer's name
                    echo "<td>" . $row['department_name'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No subjects found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
