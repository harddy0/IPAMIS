<?php
// Define the current page based on the filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <img src="../images/ctu1.png" alt="Sidebar Background Image" class="background-image">
    <div class="sidebar-content">
        <img src="../images/ctulogo.png" alt="Profile Image">
        <div class="title">IPAMIS</div>
        <div class="admin">ADMIN</div>
        
        <div class="menu">
            <!-- Manage Personal Account -->
            <a href="#" class="menu-item <?php echo $currentPage == 'adminMpa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMpa.php';">
                <span class="icon">👤</span>
                <div class="text ml-1">Manage Personal Account</div>
            </a>

            <!-- Manage Users Menu -->
            <div class="menu-item submenu-parent group relative">
                <div class="flex items-center">
                    <span class="icon">⚙️</span>
                    <div class="text">Manage Users</div>
                </div>
                <div class="submenu absolute left-full top-0 bg-blue-800 text-white hidden group-hover:flex flex-col shadow-lg">
                    <a href="faculty.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">All Faculty</a>
                    <a href="adstaff.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Admin & Staff</a>
                </div>
            </div>

            <!-- Manage IP Assets Menu -->
            <div class="menu-item submenu-parent group relative">
                <div class="flex items-center">
                    <span class="icon">💼</span>
                    <div class="text">Manage IP Assets</div>
                </div>
                <div class="submenu absolute left-full top-0 bg-blue-800 text-white hidden group-hover:flex flex-col shadow-lg">
                    <a href="addSOA.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Add SOA</a>
                    <a href="addOR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Add Official Report</a>
                    <a href="addFR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Add Formality Report</a>
                </div>
            </div>

            <!-- View IP Assets Menu -->
            <div class="menu-item submenu-parent group relative">
                <div class="flex items-center">
                    <span class="icon">📁</span>
                    <div class="text">View IP Assets</div>
                </div>
                <div class="submenu absolute left-full top-0 bg-blue-800 text-white hidden group-hover:flex flex-col shadow-lg">
                    <a href="viewSOA.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">View SOA</a>
                    <a href="viewOR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">View Official Report</a>
                    <a href="viewFR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">View Formality Report</a>
                </div>
            </div>

            <!-- View Analytics -->
            <a href="#" class="menu-item <?php echo $currentPage == 'adminVa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminVa.php';">
                <span class="icon">📊</span>
                <div class="text">View Analytics</div>
            </a>
        </div>

        <!-- Log out -->
        <a href="login.php?action=logout" class="logout flex items-center px-5 py-3 mt-auto w-full hover:bg-yellow-500 transition">
            <span class="icon text-xl mr-3">🚪</span>
            <div>Log out</div>
        </a>
    </div>
</div>
