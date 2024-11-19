<?php
// Define the current page based on the filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <img src="../images/ctu1.png" alt="Sidebar Background Image" class="background-image">
    <div class="sidebar-content">
        <img src="../images/ctulogo.png" alt="Profile Image">
        <div class="title">IPAMIS</div>
        <div class="admin">STAFF</div>
        
        <div class="menu">
            <!-- Manage Personal Account -->
            <a href="#" class="menu-item <?php echo $currentPage == 'staffmpa.php' ? 'active' : ''; ?>" onclick="window.location.href='staffmpa.php';">
                <span class="icon">👤</span>
                <div class="text ml-1">Manage Personal Account</div>
            </a>

            <!-- Manage IP Assets Menu -->
            <div class="menu-item submenu-parent group relative">
                <div class="flex items-center">
                    <span class="icon">💼</span>
                    <div class="text">Manage IP Assets</div>
                </div>
                <div class="submenu absolute left-full top-0 bg-blue-800 text-white hidden group-hover:flex flex-col shadow-lg">
                    <a href="staffaddSOA.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Add SOA</a>
                    <a href="staffaddOR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Add Official Report</a>
                    <a href="staffaddFR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">Add Formality Report</a>
                </div>
            </div>

            <!-- View IP Assets Menu -->
            <div class="menu-item submenu-parent group relative">
                <div class="flex items-center">
                    <span class="icon">📁</span>
                    <div class="text">View IP Assets</div>
                </div>
                <div class="submenu absolute left-full top-0 bg-blue-700 text-white hidden group-hover:flex flex-col shadow-lg">
                    <a href="staffviewSOA.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">View SOA</a>
                    <a href="staffviewOR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">View Official Report</a>
                    <a href="staffviewFR.php" class="submenu-item px-4 py-2 hover:bg-yellow-500">View Formality Report</a>
                </div>
            </div>

            <!-- View Analytics -->
            <a href="#" class="menu-item <?php echo $currentPage == 'staffVa.php' ? 'active' : ''; ?>" onclick="window.location.href='staffVa.php';">
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
