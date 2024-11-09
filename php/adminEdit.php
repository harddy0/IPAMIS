<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminEdit.css">
</head>
<body>
    <div class="sidebar">
        <img src="../images/ctu1.png" alt="Sidebar Background Image" class="background-image">
        <div class="sidebar-content">
            <img src="../images/ctulogo.png" alt="Profile Image">
            <div class="title">IPAMIS</div>
            <div class="admin">ADMIN</div>
            
            <div class="menu">
                <a href="#" class="menu-item active" onclick="window.location.href='adminMpa.php';">
                    <span class="icon">👤</span> Manage Personal Account
                </a>
                <a href="#" class="menu-item" onclick="window.location.href='adminMu.php';">
                    <span class="icon">⚙️</span> Manage Users
                </a>
                <a href="#" class="menu-item" onclick="window.location.href='adminMip.php';">
                    <span class="icon">💼</span> Manage IP Assets
                </a>
                <a href="#" class="menu-item" onclick="window.location.href='adminVa.php';">
                    <span class="icon">📊</span> View Analytics
                </a>
            </div>

            <div class="logout">
                <span class="icon">🚪</span> Log out
            </div>
        </div>
    </div>
    
    <div class="dashboard p-10">
    <!-- Title Section for IP Asset Management -->
    <h2 class="text-xl font-semibold text-gray-600 mb-2">IP Asset Management and Information System</h2>
    <hr class="border-gray-300 mb-5">

    <!-- New Edit Profile Section -->
    <div class="flex items-center mb-5">
        <a href="#" class="text-dark blue-500 text-lg mr-3">←</a>
        <h2 class="text-2xl font-semibold text-gray-800">Edit Profile</h2>
    </div>
    <div class="flex items-center gap-4 mb-8">
        <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center">
            <img src="../images/profile-placeholder.png" alt="Profile Image" class="w-16 h-16 rounded-full">
        </div>
        <div>
            <a href="#" class="text-blue-600 text-sm underline">Change profile picture</a>
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

<!-- Account Settings Section -->
<div class="account-settings grid grid-cols-2 gap-5 mb-8">
    <div class="account-input-group bg-blue-300 p-5 rounded-lg">
        <input type="text" placeholder="USERNAME" class="account-input w-full p-3 bg-gray-200 rounded text-gray-700 mb-4">
        <input type="email" placeholder="EMAIL ADDRESS" class="account-input w-full p-3 bg-gray-200 rounded text-gray-700">
    </div>
    <div class="password-input-group bg-blue-300 p-5 rounded-lg">
        <div class="relative mb-4">
            <input type="password" placeholder="NEW PASSWORD" class="password-input w-full p-3 bg-gray-200 rounded text-gray-700">
            <span class="eye-icon absolute right-3 top-3 text-gray-500">👁️</span>
        </div>
        <div class="relative">
            <input type="password" placeholder="CONFIRM PASSWORD" class="password-input w-full p-3 bg-gray-200 rounded text-gray-700">
            <span class="eye-icon absolute right-3 top-3 text-gray-500">👁️</span>
        </div>
    </div>
</div>

<!-- Update Button -->
<div class="update-button-container flex justify-end">
    <button class="update-button px-10 py-3 bg-yellow-600 text-white font-bold rounded hover:bg-yellow-500">UPDATE</button>
</div>



</body>
</html>
