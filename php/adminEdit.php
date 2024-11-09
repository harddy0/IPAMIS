<?php
// Start session and include necessary files
session_start();
require 'config.php'; // Include your database connection here

// Initialize variables (replace with actual database values if needed)
$employeeId = ''; // Fetch from database
$userType = ''; // Fetch from database
$firstName = '';
$middleName = '';
$lastName = '';
$campus = '';
$department = '';
$contactNumber = '';
$username = '';
$email = '';

// Handle form submission here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form inputs (update database etc.)
    // Remember to validate and sanitize inputs
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS file -->
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <div class="profile-section">
        <div class="profile-picture">
            <img src="default_profile.png" alt="Profile Picture">
            <a href="#">Change profile picture</a>
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider round"></span>
            </label>
            <span>Active status</span>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="profile-info">
                <div>
                    <label>Employee ID Number</label>
                    <input type="text" name="employee_id" value="<?php echo $employeeId; ?>" readonly>
                </div>
                <div>
                    <label>User Type</label>
                    <input type="text" name="user_type" value="<?php echo $userType; ?>" readonly>
                </div>
                <div>
                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?php echo $firstName; ?>">
                </div>
                <div>
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" value="<?php echo $middleName; ?>">
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?php echo $lastName; ?>">
                </div>
                <div>
                    <label>Campus</label>
                    <input type="text" name="campus" value="<?php echo $campus; ?>">
                </div>
                <div>
                    <label>Department</label>
                    <input type="text" name="department" value="<?php echo $department; ?>">
                </div>
                <div>
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" value="<?php echo $contactNumber; ?>">
                </div>
                <div>
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div>
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div>
                    <label>New Password</label>
                    <input type="password" id="new_password" name="new_password">
                    <span onclick="togglePassword('new_password')">👁️</span>
                </div>
                <div>
                    <label>Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                    <span onclick="togglePassword('confirm_password')">👁️</span>
                </div>
                <button type="submit" class="update-btn">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
// JavaScript for toggling password visibility
function togglePassword(id) {
    var input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
