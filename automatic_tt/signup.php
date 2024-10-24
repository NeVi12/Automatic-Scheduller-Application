<?php

$signupSuccess = false;
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
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate password pattern
    if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$/', $password)) {
        $message = "Password must contain at least one uppercase letter, one number, and one special character.";
    } else {
        // Check if admin_id or username already exists using prepared statements
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id=? OR username=?");
        $stmt->bind_param("ss", $admin_id, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Admin ID or Username already in use.";
        } else {
            // Hash the password for security
           $hashed_password = password_hash($password, PASSWORD_ARGON2ID);


            // Insert data into the admin table using prepared statements
            $stmt = $conn->prepare("INSERT INTO admin (admin_id, name, username, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $admin_id, $name, $username, $hashed_password);

            if ($stmt->execute()) {
                $signupSuccess = true;
                // Redirect to the same page to clear the form and prevent form resubmission
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                exit();  // Ensure the script stops running after the redirect
            } else {
                $message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="css/signup_styles.css">
</head>
<body>
    <button class="login-button" onclick="window.location.href='signin.php'">Already have an account?</button>

    <div class="signup-container">
        <h2>Signup</h2>
        
        <?php if (!empty($message)) { echo "<p style='color:red;'>$message</p>"; } ?>
        
        <form id="signupForm" method="POST">
            <label for="admin_id">Admin ID:</label>
            <input type="text" id="admin_id" name="admin_id" maxlength="4" required>
            <span id="adminIdError" class="error"></span>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <span id="usernameError" class="error"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span id="passwordError" class="error"></span>

            <label for="retype_password">Retype Password:</label>
            <input type="password" id="retype_password" name="retype_password" required>
            <span id="retypePasswordError" class="error"></span>

            <button type="button" onclick="validateForm()">Signup</button>
            <button type="reset">Clear</button>
        </form>
    </div>

    <script>
        // Function to display success message if redirected with success parameter
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                alert("Successfully signed up!");
            }
        }

        function validateForm() {
            let isValid = true;

            // Validate Admin ID
            const adminId = document.getElementById('admin_id').value;
            if (adminId.length !== 4 || isNaN(adminId)) {
                document.getElementById('adminIdError').textContent = "Admin ID must be 4 digits.";
                isValid = false;
            } else {
                document.getElementById('adminIdError').textContent = "";
            }

            // Validate Username
            const username = document.getElementById('username').value;
            const usernamePattern = /^[a-z0-9_]+$/;
            if (!usernamePattern.test(username)) {
                document.getElementById('usernameError').textContent = "Username can only contain lowercase letters, numbers, and underscores.";
                isValid = false;
            } else {
                document.getElementById('usernameError').textContent = "";
            }

            // Validate Password
            const password = document.getElementById('password').value;
            const retypePassword = document.getElementById('retype_password').value;
            const passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$/;

            if (!passwordPattern.test(password)) {
                document.getElementById('passwordError').textContent = "Password must contain at least one uppercase letter, one number, and one special character.";
                isValid = false;
            } else {
                document.getElementById('passwordError').textContent = "";
            }

            if (password !== retypePassword) {
                document.getElementById('retypePasswordError').textContent = "Passwords do not match.";
                isValid = false;
            } else {
                document.getElementById('retypePasswordError').textContent = "";
            }

            if (isValid) {
                document.getElementById('signupForm').submit();
            }
        }
    </script>
</body>
</html>