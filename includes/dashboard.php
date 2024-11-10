<?php

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<script src="../javascript/smooth.js"></script>
<div class="sidebar">
    <img src="../images/ctu1.png" alt="Sidebar Background Image" class="background-image">
    <div class="sidebar-content">
        <img src="../images/ctulogo.png" alt="Profile Image">
        <div class="title">IPAMIS</div>
        <div class="admin">ADMIN</div>
        
        <div class="menu">
            <a href="adminMpa.php" class="menu-item active">
                <span class="icon">👤</span>
                <div class="text ml-1">Manage Personal Account</div>
            </a>
            <a href="adminMu.php" class="menu-item">
                <span class="icon">⚙️</span>
                <div class="text">Manage Users</div>
            </a>
            <a href="adminMipa.php" class="menu-item">
                <span class="icon">💼</span> Manage IP Assets
            </a>
            <a href="adminVa.php" class="menu-item">
                <span class="icon">📊</span>
                <div class="text">View Analytics</div>
            </a>
        </div>

        <a href="login.php?action=logout" class="logout">
            <div class="logout">
                <span class="icon">🚪</span> Log out
             </div>
        </a>
    </div>
</div>
