<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Sidebar Layout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            height: 100vh; /* Full viewport height */
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px; /* Adjust width as needed */
            background-color: #f4f4f4;
            height: 100%; /* Full height of body */
        }

        .sidebar img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the full sidebar height */
            display: block;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
            height: 100%; /* Full height of body */
            overflow-y: auto; /* Adds scroll if content exceeds viewport height */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="../images/ctu1.png" alt="Sidebar Image">
    </div>
    <div class="dashboard">
        <!-- Main content goes here -->
    </div>
</body>
</html>
