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
                <a href="#" class="menu-item <?php echo $currentPage == 'adminMpa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMpa.php';">
                    <span class="icon">👤</span>
                    <div class="text ml-1">Manage Personal Account</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'adminMu.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMu.php';">
                    <span class="icon">⚙️</span>
                    <div class="text">Manage Users</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'adminMipa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminMipa.php';">
                    <span class="icon">💼</span> 
                    <div class="text">Manage IP Assets</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'adminVa.php' ? 'active' : ''; ?>" onclick="window.location.href='adminVa.php';">
                    <span class="icon">📊</span>
                    <div class="text">View Analytics</div>
                </a>
            </div>

        <a href="login.php?action=logout" class="logout">
            <div>
                <span class="icon">🚪</span> Log out
            </div>
        </a>
    </div>
</div>
