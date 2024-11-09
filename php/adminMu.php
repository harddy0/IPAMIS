<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Users</title>
    <link rel="stylesheet" href="../css/adminMu.css">
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
                <a href="#" class="menu-item">
                    <span class="icon">💼</span> Manage IP Assets
                </a>
                <a href="#" class="menu-item">
                    <span class="icon">📊</span> View Analytics
                </a>
            </div>

            <div class="logout">
                <span class="icon">🚪</span> Log out
            </div>
        </div>
    </div>
    
    <div class="dashboard">
        <h2>IP Asset Management and Information System</h2>
        <hr class="custom-line">
    </div>
</body>
</html>