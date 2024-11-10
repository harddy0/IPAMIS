<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/adminEdit.css">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Additional Custom CSS -->
    <style>
        /* Ensure the main content occupies the full width minus the sidebar */
        .main-content {
            margin-left: 16rem; /* Adjust for the sidebar width (64 in Tailwind is 16rem) */
            width: calc(100% - 16rem);
        }
    </style>
</head>
<body>
    <!-- Fixed Dashboard on the Left -->
    <div class="fixed top-0 left-0 h-full w-64 bg-white shadow-md">
        <?php include '../includes/dashboard.php'; ?>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header -->
        <div>
            <?php include '../includes/header.php'; ?>
        </div>

        <!-- Form Content Wrapper -->
        <div class="p-10 mt-10">
            <!-- Back Button and Title -->
            <div class="flex items-center mb-5">
                <a href="adminMpa.php" class="text-blue-500 text-lg mr-3">←</a>
                <h2 class="text-2xl font-semibold text-gray-800">Edit Profile</h2>
            </div>

            <!-- Profile Picture Section -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center">
                    <img src="../images/profile-placeholder.png" alt="Profile Image" class="w-16 h-16 rounded-full">
                </div>
                <div>
                    <a href="#" class="text-blue-600 text-sm underline">Change profile picture</a>
                </div>
            </div>

           <!-- Profile Information Section -->
        <div class="profile-info-section">
            <div class="profile-info-header">PROFILE INFORMATION</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="EMPLOYEE ID NUMBER" class="profile-info-input">
                <input type="text" placeholder="USER TYPE" class="profile-info-input">
                <input type="text" placeholder="FIRST NAME" class="profile-info-input">
                <input type="text" placeholder="MIDDLE NAME" class="profile-info-input">
                <input type="text" placeholder="LAST NAME" class="profile-info-input">
                <input type="text" placeholder="CAMPUS" class="profile-info-input">
                <input type="text" placeholder="DEPARTMENT" class="profile-info-input">
                <input type="text" placeholder="CONTACT NUMBER" class="profile-info-input">
            </div>
        </div>

        <!-- Account Settings Section -->
        <div class="account-settings-section">
            <div class="account-settings-card">
                <input type="email" placeholder="EMAIL ADDRESS" class="account-settings-input">
            </div>
            <div class="account-settings-card">
                <input type="password" placeholder="NEW PASSWORD" class="account-settings-input">
            </div>
            <div class="account-settings-card">
                <input type="password" placeholder="CONFIRM PASSWORD" class="account-settings-input">
            </div>
        </div>


            <!-- Centered Update Button -->
            <div class="flex justify-center mb-10">
                <button class="px-10 py-3 bg-yellow-600 text-white font-bold rounded hover:bg-yellow-500">UPDATE</button>
            </div>
        </div>

        <!-- Footer -->
        <div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>
