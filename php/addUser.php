<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/adminEdit.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        /* Ensure the main content occupies the full width minus the sidebar */
        .main-content {
            margin-left: 16rem;
            width: calc(100% - 16rem);
        }
    </style>
</head>
<body>
    <?php
    include '../includes/db_connect.php';

    // Initialize variables and error messages
    $error_message = "";
    $next_employee_id = 1;

    // Fetch the next Employee ID
    $result = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'user' AND TABLE_SCHEMA = DATABASE()");
        if ($result && $row = $result->fetch_assoc()) {
            $next_employee_id = $row['AUTO_INCREMENT'];
        }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_type = htmlspecialchars(trim($_POST['user_type']));
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $middle_name = htmlspecialchars(trim($_POST['middle_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $campus = htmlspecialchars(trim($_POST['campus']));
        $department = htmlspecialchars(trim($_POST['department']));
        $contact_number = htmlspecialchars(trim($_POST['contact_number']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

        // Check if passwords match
        if ($password !== $confirm_password) {
            $error_message = "Passwords do not match.";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO user (FirstName, MiddleName, LastName, Password, EmailAddress, ContactNumber, Campus, Department, UserType, Status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $password, $email, $contact_number, $campus, $department, $user_type);

            if ($stmt->execute()) {
                header("Location: adminMpa.php");
                exit;
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    ?>

    <!-- Fixed Dashboard on the Left -->
    <div class="fixed top-0 left-0 h-full w-64 bg-white shadow-md">
        <?php include '../includes/dashboard.php'; ?>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header -->
        
        <?php include '../includes/header.php'; ?>
        

        <!-- Main Add User Content Wrapper -->
        <div class="p-10 pt-2 mt-4">
            <div class="flex items-center mb-5">
                <a href="adminMpa.php" class="text-blue-500 text-lg mr-3">←</a>
                <h2 class="text-2xl font-semibold text-gray-800">Add User</h2>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="bg-red-500 text-white p-3 rounded mb-5"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center">
                    <img src="../images/profile-placeholder.png" alt="Profile Image" class="w-16 h-16 rounded-full">
                </div>
                <div>
                    <a href="#" class="text-blue-600 text-sm underline">Add profile picture</a>
                </div>
            </div>

            <!-- Profile Information Section -->
            <form action="" method="POST">
                <div class="bg-blue-500 p-6 rounded-lg mb-8">
                    <div class="bg-blue-900 text-white text-center py-2 font-bold rounded mb-5">PROFILE INFORMATION</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-white">Employee ID Number</label>
                            <input type="text" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo $next_employee_id; ?>" disabled>
                        </div>
                        <div>
                            <label class="text-white">User Type</label>
                            <select name="user_type" class="p-3 bg-gray-200 rounded text-gray-700 w-full" required>
                                <option value="">Select User Type</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-white">First Name</label>
                            <input type="text" name="first_name" class="p-3 bg-gray-200 rounded text-gray-700 w-full" placeholder="FIRST NAME" required>
                        </div>
                        <div>
                            <label class="text-white">Middle Name</label>
                            <input type="text" name="middle_name" class="p-3 bg-gray-200 rounded text-gray-700 w-full" placeholder="MIDDLE NAME">
                        </div>
                        <div>
                            <label class="text-white">Last Name</label>
                            <input type="text" name="last_name" class="p-3 bg-gray-200 rounded text-gray-700 w-full" placeholder="LAST NAME" required>
                        </div>
                        <div>
                            <label class="text-white">Campus</label>
                            <input type="text" name="campus" class="p-3 bg-gray-200 rounded text-gray-700 w-full" placeholder="CAMPUS">
                        </div>
                        <div>
                            <label class="text-white">Department</label>
                            <input type="text" name="department" class="p-3 bg-gray-200 rounded text-gray-700 w-full" placeholder="DEPARTMENT">
                        </div>
                        <div>
                            <label class="text-white">Contact Number</label>
                            <input type="text" name="contact_number" class="p-3 bg-gray-200 rounded text-gray-700 w-full" placeholder="CONTACT NUMBER">
                        </div>
                    </div>
                </div>

                <!-- Account Settings Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                    <div class="bg-blue-500 p-2 rounded-md">
                        <label class="text-white">Email Address</label>
                        <input type="email" name="email" class="w-full p-3 bg-gray-200 rounded text-gray-700" placeholder="EMAIL ADDRESS" required>
                    </div>
                    <div class="bg-blue-500 p-2 rounded-md">
                        <label class="text-white">New Password</label>
                        <input type="password" name="password" class="w-full p-3 bg-gray-200 rounded text-gray-700" placeholder="NEW PASSWORD" required>
                    </div>
                    <div class="bg-blue-500 p-2 rounded-md">
                        <label class="text-white">Confirm Password</label>
                        <input type="password" name="confirm_password" class="w-full p-3 bg-gray-200 rounded text-gray-700" placeholder="CONFIRM PASSWORD" required>
                    </div>
                </div>

                <!-- Centered Add User Button -->
                <div class="flex justify-center mb-10">
                    <button type="submit" class="px-10 py-3 bg-yellow-600 text-white font-bold rounded hover:bg-yellow-500">ADD USER</button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>