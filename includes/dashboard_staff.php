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
                <a href="#" class="menu-item <?php echo $currentPage == 'staffMpa.php' ? 'active' : ''; ?>" onclick="window.location.href='staffMpa.php';">
                    <span class="icon">👤</span>
                    <div class="text ml-1">Manage Personal Account</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'staffMipa.php' ? 'active' : ''; ?>" onclick="window.location.href='staffMipa.php';">
                    <span class="icon">💼</span> 
                    <div class="text">Manage IP Assets</div>
                </a>
                <a href="#" class="menu-item <?php echo $currentPage == 'staffVA.php' ? 'active' : ''; ?>" onclick="window.location.href='staffVA.php';">
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
