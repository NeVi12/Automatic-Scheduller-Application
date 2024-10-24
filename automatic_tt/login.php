<?php
session_start(); // Start the session

// Assuming you've validated the username and password
$admin_id = // Fetch the admin ID from the database after login
$_SESSION['admin_id'] = $admin_id;

// Redirect to the employee form or another page
header("Location: index.php");
exit();
?>
