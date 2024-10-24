<?php
session_start();  // Start a session at the beginning of the script

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$signinSuccess = false;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database configuration
    $servername = "localhost";
    $db_username = "root";  // default XAMPP username
    $db_password = "";  // default XAMPP password
    $dbname = "automatic_tt";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to retrieve the user
    $stmt = $conn->prepare("SELECT password FROM admin WHERE admin_id=? AND username=?");
    $stmt->bind_param("ss", $admin_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Fetch the stored hashed password
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the entered password
        if (password_verify($password, $hashed_password)) {
            $signinSuccess = true;

            // Store admin_id in session
            $_SESSION['admin_id'] = $admin_id;

            // Redirect to the employee form page upon successful login
            header("Location: welcome.php");
            exit();  // Ensure the script stops running after the redirect
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "Admin ID or Username is incorrect.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signin</title>
    <link rel="stylesheet" href="css/signin_styles.css">
</head>
<body>
    <button class="signup-button" onclick="window.location.href='signup.php'">Create an account</button>

    <div class="signin-container">
        <h2>Signin</h2>
        
        <?php if (!empty($message)) { echo "<p style='color:red;'>$message</p>"; } ?>
        
        <form id="signinForm" method="POST">
            <label for="admin_id">Admin ID:</label>
            <input type="text" id="admin_id" name="admin_id" maxlength="4" required>
            <span id="adminIdError" class="error"></span>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <span id="usernameError" class="error"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span id="passwordError" class="error"></span>

            <button type="submit">Signin</button>
            <button type="reset">Clear</button>
        </form>
    </div>

    <script>
        // Function to display success message if redirected with success parameter
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                alert("Successfully signed in!");
            }
        }
    </script>

<script>
window.addEventListener('load', function() {
    // Clear sessionStorage to ensure no sensitive data remains
    sessionStorage.clear();
});
</script>


</body>
</html>
