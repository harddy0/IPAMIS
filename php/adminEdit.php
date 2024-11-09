<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Sidebar Layout</title>
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
                <a href="#" class="menu-item active">
                    <span class="icon">👤</span> Manage Personal Account
                </a>
                <a href="#" class="menu-item">
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
      <h2>Edit Profile</h2>
        <div class="profile-section">
            <div class="profile-image">
                <img src="../images/profile-placeholder.png" alt="Profile Image">
                <a href="#">Change profile picture</a>
                <div class="status">
                    Active status <input type="checkbox" checked>
                </div>
            </div>
            <div class="profile-info">
                <div class="section-title">Profile Information</div>
                <div class="form-row">
                    <input type="text" placeholder="Employee ID Number">
                    <input type="text" placeholder="User Type">
                </div>
                <div class="form-row">
                    <input type="text" placeholder="First Name">
                    <input type="text" placeholder="Middle Name">
                    <input type="text" placeholder="Last Name">
                </div>
                <div class="form-row">
                    <input type="text" placeholder="Campus">
                    <input type="text" placeholder="Department">
                    <input type="text" placeholder="Contact Number">
                </div>
                <div class="form-row">
                    <input type="text" placeholder="Username">
                    <input type="email" placeholder="Email Address">
                </div>
                <div class="form-row">
                    <input type="password" placeholder="New Password">
                    <input type="password" placeholder="Confirm Password">
                </div>
                <button class="update-button">Update</button>
            </div>
        </div>
    </div>
</body>
</html>
