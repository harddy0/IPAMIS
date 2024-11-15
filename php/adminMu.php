<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminMu.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Functions for button clicks
        function showFaculty() {
            console.log("Showing All Faculty");
            // Placeholder for future functionality
        }

        function showAdminStaff() {
            console.log("Showing Admin & Staff");
            // Placeholder for future functionality
        }
    </script>
</head>
<body>
    <?php include '../includes/dashboard.php'; ?>
    <?php include '../includes/header.php'; ?>

    <!-- Main Content -->
    <div class="flex-grow flex flex-col items-center justify-center p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-10">Manage Users</h1>
        
        <!-- Centered Buttons -->
        <div class="flex flex-col items-center space-y-6">
            <button onclick="window.location.href='faculty.php'" class="w-56 h-16 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
                ALL FACULTY
            </button>
            <button onclick="window.location.href='adstaff.php'" class="w-56 h-16 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
                ADMIN & STAFF
            </button>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
