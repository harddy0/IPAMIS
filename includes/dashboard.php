<script src="../javascript/smooth.js"></script>
<div class="sidebar">
        <img src="../images/ctu1.png" alt="Sidebar Background Image" class="background-image">
        <div class="sidebar-content">
            <img src="../images/ctulogo.png" alt="Profile Image">
            <div class="title">IPAMIS</div>
            <div class="admin">ADMIN</div>
            
            <div class="menu">
                <a href="#" class="menu-item active" data-target="profile-section" onclick="window.location.href='adminMpa.php';">
                    <span class="icon">👤</span>
                    <div class="text ml-1">Manage Personal Account</div>
                </a>
                <a href="#" class="menu-item" data-target="manage-users-section" onclick="window.location.href='adminMu.php';">
                    <span class="icon">⚙️</span>
                    <div class="text">Manage Users</div>
                </a>
                <a href="#" class="menu-item" onclick="window.location.href='adminMipa.php';">
                    <span class="icon">💼</span> Manage IP Assets
                </a>
                <a href="#" class="menu-item" data-target="view-analytics-section" onclick="window.location.href='adminVa.php';">
                    <span class="icon">📊</span>
                    <div class="text">Manage IP Assets</div>
                </a>
            </div>

            <a href="login.php" class="logout"><div class="logout">
                <span class="icon">🚪</span> Log out
            </div>
            </a>
        </div>
    </div>