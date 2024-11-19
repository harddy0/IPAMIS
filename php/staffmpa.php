<?php
session_start(); // Start the session to access session variables
include '../includes/db_connect.php';


// Retrieve the logged-in user's ID
$userID = $_SESSION['UserID'];
$sql = "SELECT FirstName, LastName, EmailAddress, ContactNumber, Campus, Department, UserID FROM user WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullName = $user['FirstName'] . ' ' . $user['LastName'];
    $email = $user['EmailAddress'];
    $contactNumber = $user['ContactNumber'];
    $campus = $user['Campus'];
    $department = $user['Department'];
    $employeeID = $user['UserID'];
} else {
    echo "User not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Personal Account</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/dashboard_staff.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <?php include '../includes/dashboard_staff.php'; ?>
    <?php include '../includes/header.php'; ?>
    
    <div class="profile-section p-10 m-6 mt-10 pb-16 shadow-xl">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">PROFILE</h3>
        <div class="profile-container flex gap-6">
            <!-- Left Profile Card -->
            <div class="profile-left rounded-lg p-6 flex flex-col items-center w-1/4 shadow-lg">
                <div class="profile-picture mb-4">
                    <img src="<?php echo htmlspecialchars($userImagePath); ?>" alt="Profile Picture" class="w-24 h-24 rounded-full bg-black">
                </div>
                <div class="profile-info text-center">
                    <p class="profile-name text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($fullName); ?></p>
                    <p class="profile-role text-sm text-gray-500">STAFF</p>
                    <a href="staffEdit.php">
                        <button class="edit-profile bg-gold-500 text-white rounded mt-4 py-2 px-4 hover:bg-gold-600">
                            Edit Profile
                        </button>
                    </a>
                </div>
            </div>

            <!-- Right Profile Details -->
            <div class="profile-right grid grid-cols-2 gap-4 w-3/4">
                <div class="profile-detail">
                    <p class="text-sm text-gray-500">Full Name</p>
                    <div class="detail-box bg-gray-200 p-3 rounded text-gray-800"><?php echo htmlspecialchars($fullName); ?></div>
                </div>
                <div class="profile-detail">
                    <p class="text-sm text-gray-500">Contact Number</p>
                    <div class="detail-box bg-gray-200 p-3 rounded text-gray-800"><?php echo htmlspecialchars($contactNumber); ?></div>
                </div>
                <div class="profile-detail">
                    <p class="text-sm text-gray-500">Email Address</p>
                    <div class="detail-box bg-gray-200 p-3 rounded text-gray-800"><?php echo htmlspecialchars($email); ?></div>
                </div>
                <div class="profile-detail">
                    <p class="text-sm text-gray-500">Campus</p>
                    <div class="detail-box bg-gray-200 p-3 rounded text-gray-800"><?php echo htmlspecialchars($campus); ?></div>
                </div>
                <div class="profile-detail">
                    <p class="text-sm text-gray-500">Employee ID Number</p>
                    <div class="detail-box bg-gray-200 p-3 rounded text-gray-800"><?php echo htmlspecialchars($employeeID); ?></div>
                </div>
                <div class="profile-detail">
                    <p class="text-sm text-gray-500">Department</p>
                    <div class="detail-box bg-gray-200 p-3 rounded text-gray-800"><?php echo htmlspecialchars($department); ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>