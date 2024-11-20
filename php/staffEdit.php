<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/adminEdit.css">
    <link rel="stylesheet" href="../css/dashboard_staff.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Additional Custom CSS -->
    <style>
        .main-content {
            margin-left: 16rem;
            width: calc(100% - 16rem);
        }
    </style>
    <script>
        function validatePassword() {
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            if (newPassword !== confirmPassword) {
                showModal("Passwords do not match. Please check and try again.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        function validateForm() {
            const inputs = document.querySelectorAll("input[type='text'], input[type='email'], input[type='password']");
            let isValid = true;

            // Check if fields are empty
            inputs.forEach(input => {
                if (!input.value.trim() && !input.hasAttribute('readonly') && !input.disabled) {
                    isValid = false;
                }
            });

            if (!isValid) {
                showModal("Please fill out all required fields before proceeding.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        function showModal(message) {
            const modal = document.getElementById("error-modal");
            const modalMessage = document.getElementById("modal-message");
            modalMessage.textContent = message;
            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden"; // Disable scrolling
        }

        function closeModal() {
            const modal = document.getElementById("error-modal");
            modal.classList.add("hidden");
            document.body.style.overflow = "auto"; // Re-enable scrolling
        }
    </script>
</head>
<body>
    <?php
    session_start();
    include '../includes/db_connect.php';

    $user_id = $_SESSION['UserID'];
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
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employee_id = htmlspecialchars(trim($_POST['employee_id']));
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $middle_name = htmlspecialchars(trim($_POST['middle_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $campus = htmlspecialchars(trim($_POST['campus']));
        $department = htmlspecialchars(trim($_POST['department']));
        $contact_number = htmlspecialchars(trim($_POST['contact_number']));
        $email = htmlspecialchars(trim($_POST['email']));
        $new_password = htmlspecialchars(trim($_POST['new_password']));

        if (!empty($new_password)) {
            $sql = "UPDATE user SET UserID = ?, FirstName = ?, MiddleName = ?, LastName = ?, Campus = ?, Department = ?, ContactNumber = ?, EmailAddress = ?, Password = ? WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssssi", $employee_id, $first_name, $middle_name, $last_name, $campus, $department, $contact_number, $email, $new_password, $user_id);
        } else {
            $sql = "UPDATE user SET UserID = ?, FirstName = ?, MiddleName = ?, LastName = ?, Campus = ?, Department = ?, ContactNumber = ?, EmailAddress = ? WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssssi", $employee_id, $first_name, $middle_name, $last_name, $campus, $department, $contact_number, $email, $user_id);
        }
        
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['UserID'] = $employee_id; // Update session variable
        header("Location: staffmpa.php");
        exit();
    }
    ?>

    <div class="fixed top-0 left-0 h-full w-64 bg-white shadow-md">
        <?php include '../includes/dashboard_staff.php'; ?>
    </div>

    <div class="main-content">
        <?php include '../includes/header.php'; ?>
        
        <div class="p-10 pt-2 mt-4">
            <div class="flex items-center mb-5">
                <a href="staffmpa.php" class="text-blue-500 text-lg mr-3">←</a>
                <h2 class="text-2xl font-semibold text-gray-800">Edit Profile</h2>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" onsubmit="return validatePassword() && validateForm()">
                <div class="bg-blue-800 p-6 rounded-lg mb-8">
                    <div class="bg-blue-700 text-white text-center py-2 font-bold rounded mb-5">PROFILE INFORMATION</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-white">Employee ID Number</label>
                            <input type="text" name="employee_id" class="p-3 bg-gray-200 rounded text-gray-700 w-full" value="<?php echo htmlspecialchars($user_data['UserID'] ?? ''); ?>" readonly>
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
                    <div class="bg-blue-800 p-2 rounded-md">
                        <label class="text-white">Email Address</label>
                        <input type="email" name="email" class="w-full p-3 bg-gray-200 rounded text-gray-700" value="<?php echo htmlspecialchars($user_data['EmailAddress'] ?? ''); ?>">
                    </div>
                    <div class="bg-blue-800 p-2 rounded-md">
                        <label class="text-white">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="w-full p-3 bg-gray-200 rounded text-gray-700">
                    </div>
                    <div class="bg-blue-800 p-2 rounded-md">
                        <label class="text-white">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="w-full p-3 bg-gray-200 rounded text-gray-700">
                    </div>
                </div>

                <div class="flex justify-center mb-10">
                    <button type="submit" class="px-10 py-3 bg-yellow-600 text-white font-bold rounded hover:bg-yellow-500">UPDATE</button>
                </div>
            </form>
        </div>

        <!-- Modal -->
        <div id="error-modal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 backdrop-blur-sm">
            <div class="bg-white rounded-lg shadow-lg p-6 w-3/4 max-w-md text-center">
                <h2 class="text-red-600 font-bold text-lg mb-4">Error</h2>
                <p id="modal-message" class="text-gray-700">Please fill out all required fields before proceeding.</p>
                <button onclick="closeModal()" class="mt-4 px-6 py-2 bg-red-600 text-white font-bold rounded hover:bg-red-500">
                    Close
                </button>
            </div>
        </div>

        <div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>
