<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Staff Profile</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/adminEdit.css">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        .main-content {
            margin-left: 16rem;
            width: calc(100% - 16rem);
        }
    </style>
</head>
<body>
    <?php
    include '../includes/db_connect.php';

    // Get user_id from the URL to fetch and edit the targeted user
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;
    $user_data = [];

    if ($user_id) {
        $stmt = $conn->prepare("SELECT * FROM user WHERE UserID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
        }
        $stmt->close();
    } else {
        // Redirect to adminMu.php if no user_id is provided
        header("Location: adminMu.php");
        exit();
    }

    // Handle form submission to update the user's data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $middle_name = htmlspecialchars(trim($_POST['middle_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $campus = htmlspecialchars(trim($_POST['campus']));
        $department = htmlspecialchars(trim($_POST['department']));
        $contact_number = htmlspecialchars(trim($_POST['contact_number']));
        $email = htmlspecialchars(trim($_POST['email']));
        $new_password = htmlspecialchars(trim($_POST['new_password']));

        // Update query
        if (!empty($new_password)) {
            $sql = "UPDATE user SET FirstName = ?, MiddleName = ?, LastName = ?, Campus = ?, Department = ?, ContactNumber = ?, EmailAddress = ?, Password = ? WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssi", $first_name, $middle_name, $last_name, $campus, $department, $contact_number, $email, $new_password, $user_id);
        } else {
            $sql = "UPDATE user SET FirstName = ?, MiddleName = ?, LastName = ?, Campus = ?, Department = ?, ContactNumber = ?, EmailAddress = ? WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $first_name, $middle_name, $last_name, $campus, $department, $contact_number, $email, $user_id);
        }
        $stmt->execute();
        $stmt->close();

        // Redirect back to the manage users page after updating
        header("Location: adminMu.php");
        exit();
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

        <!-- Form Content Wrapper -->
        <div class="p-10 mt-10">
            <div class="flex items-center mb-5">
                <a href="adminMu.php" class="text-blue-500 text-lg mr-3">←</a>
                <h2 class="text-2xl font-semibold text-gray-800">Edit Staff Profile</h2>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?user_id=" . $user_id); ?>" method="POST">
                <div class="bg-blue-500 p-6 rounded-lg mb-8">
                    <div class="bg-blue-900 text-white text-center py-2 font-bold rounded mb-5">PROFILE INFORMATION</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-white">Employee ID Number</label>
                            <input type="text" name="employee_id" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['UserID'] ?? ''); ?>" disabled>
                        </div>
                        <div>
                            <label class="text-white">User Type</label>
                            <input type="text" name="user_type" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['UserType'] ?? ''); ?>" disabled>
                        </div>
                        <div>
                            <label class="text-white">First Name</label>
                            <input type="text" name="first_name" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['FirstName'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="text-white">Middle Name</label>
                            <input type="text" name="middle_name" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['MiddleName'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="text-white">Last Name</label>
                            <input type="text" name="last_name" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['LastName'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="text-white">Campus</label>
                            <input type="text" name="campus" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['Campus'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="text-white">Department</label>
                            <input type="text" name="department" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['Department'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="text-white">Contact Number</label>
                            <input type="text" name="contact_number" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['ContactNumber'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                    <div class="bg-blue-500 p-5 rounded-lg">
                        <label class="text-white">Email Address</label>
                        <input type="email" name="email" class="w-full p-3 bg-gray-200 rounded text-gray-700" value="<?php echo htmlspecialchars($user_data['EmailAddress'] ?? ''); ?>">
                    </div>
                    <div class="bg-blue-500 p-5 rounded-lg">
                        <label class="text-white">New Password</label>
                        <input type="password" name="new_password" class="w-full p-3 bg-gray-200 rounded text-gray-700">
                    </div>
                    <div class="bg-blue-500 p-5 rounded-lg">
                        <label class="text-white">Confirm Password</label>
                        <input type="password" name="confirm_password" class="w-full p-3 bg-gray-200 rounded text-gray-700">
                    </div>
                </div>

                <div class="flex justify-center mb-10">
                    <button type="submit" class="px-10 py-3 bg-yellow-600 text-white font-bold rounded hover:bg-yellow-500">UPDATE</button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>
</body>
</html>