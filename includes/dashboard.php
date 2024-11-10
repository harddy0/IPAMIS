<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get the name of the current file
?>
<div class="sidebar">
        <img src="../images/ctu1.png" alt="Sidebar Background Image" class="background-image">
        <div class="sidebar-content">
            <img src="../images/ctulogo.png" alt="Profile Image">
            <div class="title">IPAMIS</div>
            <div class="admin">ADMIN</div>
            
            <div class="menu">
                <a href="#" class="menu-item <?php echo $currentPage == 'adminMpa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMpa.php';">
                    <span class="icon">👤</span>
                    <div class="text ml-1">Manage Personal Account</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'adminMu.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMu.php';">
                    <span class="icon">⚙️</span>
                    <div class="text">Manage Users</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'adminMip.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMip.php';">
                    <span class="icon">💼</span> 
                    <div class="text">Manage IP Assets</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'adminVa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminVa.php';">
                    <span class="icon">📊</span>
                    <div class="text">View Analytics</div>
                </a>
            </div>

            <div class="logout">
                <span class="icon">🚪</span> Log out
            </div>
        </div>
    </div>