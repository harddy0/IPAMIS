<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Asset Management and Information System - Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 250px;
            color: #fff;
            padding: 20px;
            background: url("images/ctu1.png") no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(40, 53, 147, 0.85); /* Add overlay color */
            z-index: 1;
        }

        .sidebar h2, .sidebar .role, .menu li {
            position: relative;
            z-index: 2;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .role {
            font-weight: bold;
            color: #fdd835;
            margin-bottom: 20px;
        }

        .menu {
            list-style-type: none;
        }

        .menu li {
            margin: 15px 0;
        }

        .menu li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }

        .menu .active a {
            background-color: #fdd835;
            padding: 10px 15px;
            border-radius: 5px;
            display: block;
        }

        .profile-content {
            padding: 40px;
            width: 100%;
        }

        .profile-card {
            display: flex;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-picture {
            width: 40%;
            background-color: #c5cae9;
            text-align: center;
            padding: 20px;
        }

        .profile-picture img {
            width: 100px;
            border-radius: 50%;
        }

        .profile-picture h2 {
            margin: 10px 0;
            color: #283593;
        }

        .profile-info {
            width: 60%;
            padding: 20px;
        }

        .profile-info form p {
            font-size: 16px;
            margin: 10px 0;
            background-color: #e8eaf6;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-info form input[type="text"] {
            width: 70%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .profile-info form button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #283593;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
<aside class="sidebar">
    <div class="sidebar-header">
        <img src="ctulogo.png" alt="Logo" class="logo-left">
        <h2>IPAMIS</h2>
        <img src="pilipinas.png" alt="Logo" class="logo-right">
    </div>
    <p class="role">ADMIN</p>
    <ul class="menu">
        <li class="active"><a href="#">Manage Personal Account</a></li>
        <li><a href="#">Manage Users</a></li>
        <li><a href="#">Manage IP Assets</a></li>
        <li><a href="#">View Analytics</a></li>
        <li><a href="#">Log out</a></li>
    </ul>
</aside>

    
    <main class="profile-content">
        <h1>PROFILE</h1>
        <div class="profile-card">
            <div class="profile-picture">
                <img src="avatar.png" alt="Profile Picture">
                <h2>Silvers Rayleigh</h2>
                <p>ADMIN</p>
                <button>Edit Profile</button>
            </div>
            <div class="profile-info">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <p><strong>Full Name:</strong> <input type="text" name="full_name" value="Silvers Rayleigh"></p>
                    <p><strong>Contact Number:</strong> <input type="text" name="contact_number" value="09694108829"></p>
                    <p><strong>Email Address:</strong> <input type="text" name="email_address" value="silvers.rayleigh@ctu.itso"></p>
                    <p><strong>Campus:</strong> <input type="text" name="campus" value="CTU - Main Campus"></p>
                    <p><strong>Employee ID Number:</strong> <input type="text" name="employee_id" value="114589"></p>
                    <p><strong>Department:</strong> <input type="text" name="department" value="CCICT - College of Computer and Information Technology"></p>
                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </main>
</div>

</body>
</html>
