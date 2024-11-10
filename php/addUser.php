<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminEdit.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/footer.css">

</head>
<body>
    <?php include '../includes/dashboard.php'; ?>

    
    <div class="dashboard p-10">
    <!-- Title Section for IP Asset Management -->
    <h2 class="text-xl font-semibold text-gray-600 mb-2">IP Asset Management and Information System</h2>
    <hr class="border-gray-300 mb-5">

    <!-- New Edit Profile Section -->
    <div class="flex items-center mb-5">
        <a href="adminMu.php" class="text-dark blue-500 text-lg mr-3">←</a>
        <h2 class="text-2xl font-semibold text-gray-800">Add User</h2>
    </div>
    <div class="flex items-center gap-4 mb-8">
        <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center">
            <img src="../images/profile-placeholder.png" alt="Profile Image" class="w-16 h-16 rounded-full">
        </div>
        <div>
            <a href="#" class="text-blue-600 text-sm underline">Add profile picture</a>
        </div>
    </div>

    <!-- Profile Information Section -->
<div class="profile-section bg-blue-500 p-6 rounded-lg mb-8">
    <div class="profile-header bg-blue-900 text-white text-center py-2 font-bold rounded mb-5">PROFILE INFORMATION</div>
    <div class="profile-grid grid grid-cols-2 gap-4">
        <input type="text" placeholder="EMPLOYEE ID NUMBER" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="USER TYPE" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="FIRST NAME" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="MIDDLE NAME" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="LAST NAME" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="CAMPUS" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="DEPARTMENT" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
        <input type="text" placeholder="CONTACT NUMBER" class="profile-input p-3 bg-gray-200 rounded text-gray-700">
    </div>
</div>

<div class="account-settings grid grid-cols-3 gap-5 mb-8">
    <div class="account-input-group bg-blue-300 p-5 rounded-lg">
        <input type="email" placeholder="EMAIL ADDRESS" class="account-input w-full p-3 bg-gray-200 rounded text-gray-700">
    </div>
    <div class="password-input-group bg-blue-300 p-5 rounded-lg">
        <input type="password" placeholder="NEW PASSWORD" class="password-input w-full p-3 bg-gray-200 rounded text-gray-700">
    </div>
    <div class="password-input-group bg-blue-300 p-5 rounded-lg">
        <input type="password" placeholder="CONFIRM PASSWORD" class="password-input w-full p-3 bg-gray-200 rounded text-gray-700">
    </div>
</div>

<!-- Centered Update Button -->
<div class="flex justify-center mb-10">
    <button class="update-button px-10 py-3 bg-yellow-600 text-white font-bold rounded hover:bg-yellow-500">ADD USER</button>
</div>


<?php include '../includes/footer.php'; ?>

</body>
</html>
