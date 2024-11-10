<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Personal Account</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="../javascript/smooth.js"></script>
</head>
<body>
    <?php include '../includes/dashboard.php'; ?>
    <?php include '../includes/header.php'; ?>
    
        <div class="profile-section p-10 m-6 mt-10 pb-16 shadow-xl">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">PROFILE</h3>
            <div class="profile-container flex gap-6">
                <!-- Left Profile Card -->
                <div class="profile-left  rounded-lg p-6 flex flex-col items-center w-1/4 shadow-lg">
                    <div class="profile-picture mb-4">
                    <img src="<?php echo htmlspecialchars($userImagePath); ?>" alt="Profile Picture" class="w-24 h-24 rounded-full">
                    </div>
                    <div class="profile-info text-center">
                        <p class="profile-name text-lg font-semibold text-gray-800">Silvers Rayleigh</p>
                        <p class="profile-role text-sm text-gray-500">ADMIN</p>
                        <a href="adminEdit.php"><button class="edit-profile bg-gold-500 text-white rounded mt-4 py-2 px-4 hover:bg-gold-600">
                            Edit Profile
                        </button></a>
                    </div>
                </div>

                <!-- Right Profile Details -->
                <div class="profile-right grid grid-cols-2 gap-4 w-3/4">
                    <div class="profile-detail">
                        <p class="text-sm text-gray-500">Full Name</p>
                        <div class="detail-box bg-gray-200 p-3 rounded text-gray-800">Silvers Rayleigh</div>
                    </div>
                    <div class="profile-detail">
                        <p class="text-sm text-gray-500">Contact Number</p>
                        <div class="detail-box bg-gray-200 p-3 rounded text-gray-800">09694108829</div>
                    </div>
                    <div class="profile-detail">
                        <p class="text-sm text-gray-500">Email Address</p>
                        <div class="detail-box bg-gray-200 p-3 rounded text-gray-800">silvers.rayleigh@ctu.tso</div>
                    </div>
                    <div class="profile-detail">
                        <p class="text-sm text-gray-500">Campus</p>
                        <div class="detail-box bg-gray-200 p-3 rounded text-gray-800">CTU - Main Campus</div>
                    </div>
                    <div class="profile-detail">
                        <p class="text-sm text-gray-500">Employee ID Number</p>
                        <div class="detail-box bg-gray-200 p-3 rounded text-gray-800">114589</div>
                    </div>
                    <div class="profile-detail">
                        <p class="text-sm text-gray-500">Department</p>
                        <div class="detail-box bg-gray-200 p-3 rounded text-gray-800">CCICT - College of Computer and Information Technology</div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </div>


</body>
</html>