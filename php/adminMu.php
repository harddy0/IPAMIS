<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMu.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script>
        function confirmDelete(userId, userName) {
            document.getElementById('confirm-delete-modal').classList.remove('hidden');
            document.getElementById('delete-user-id').value = userId;
            document.getElementById('delete-user-name').textContent = userName;
        }

        function closeModal() {
            document.getElementById('confirm-delete-modal').classList.add('hidden');
        }
    </script>
</head>
<body>
    <?php
    include '../includes/db_connect.php';

    // Check if connection was successful
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Handle delete action if delete_id is set in the POST request
    if (isset($_POST['delete_id'])) {
        $delete_id = intval($_POST['delete_id']);
        $stmt = $conn->prepare("DELETE FROM user WHERE UserID = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();

        // Redirect back to adminMu.php with a 'deleted' flag
        header("Location: adminMu.php?deleted=true");
        exit();
    }

    // Fetch staff users from the database
    $staff_query = "SELECT UserID, CONCAT(FirstName, ' ', LastName) AS FullName FROM user WHERE UserType = 'Staff'";
    $staff_result = $conn->query($staff_query);

    // Check if query was successful
    if (!$staff_result) {
        die("Query failed: " . $conn->error);
    }

    // Check if any staff members were found
    $staff_users = [];
    if ($staff_result->num_rows > 0) {
        $staff_users = $staff_result->fetch_all(MYSQLI_ASSOC);
    } 
    ?>

    <!-- Dashboard and Header -->
    <?php include '../includes/dashboard.php'; ?>
    <?php include '../includes/header.php'; ?>

    <div class="container p-4 mt-10 pb-10 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
            <button class="custom-add-button bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-600" onclick="window.location.href='addUser.php'">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                ADD
            </button>
            <div class="relative">
                <input type="text" class="bg-gray-300 rounded-full py-2 px-4 text-gray-700" placeholder="Search">
                <button class="absolute right-2 top-2 text-gray-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                        <line x1="16.65" y1="16.65" x2="21" y2="21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-10">
            <!-- Left Column: List of Staff -->
            <div id="list-staff">
                <div class="bg-gray-700 text-white font-semibold rounded-t px-4 py-2">List of Staff</div>
                <ul class="bg-gray-300 text-gray-800 rounded-b">
                    <?php if (!empty($staff_users)): ?>
                        <?php foreach ($staff_users as $user): ?>
                            <li class="px-4 py-2 border-b">
                                <?php echo $user['UserID'] . " - " . $user['FullName']; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="px-4 py-2 text-gray-500">No staff found.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Middle Column: Faculty Requests (Placeholder) -->
            <div id="faculty-requests">
                <div class="bg-blue-700 text-white font-semibold rounded-t px-4 py-2 flex items-center justify-between">
                    Faculty Request
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a7 7 0 00-7 7v3.5l-1.26 2.52A1 1 0 005 17h14a1 1 0 00.86-1.48L18 12.5V9a7 7 0 00-7-7zm1 16h-2a2 2 0 004 0h-2z"></path>
                    </svg>
                </div>
                <div class="bg-gray-300 rounded-b">
                    <div class='px-4 py-2 flex items-center justify-between'>
                        <span>Shekinah Olarte</span>
                        <div>
                            <button class='accept-button mr-2'>Accept</button>
                            <button class='decline-button'>Decline</button>
                        </div>
                    </div>
                    <div class='px-4 py-2 flex items-center justify-between'>
                        <span>Dahlia Genson</span>
                        <div>
                            <button class='accept-button mr-2'>Accept</button>
                            <button class='decline-button'>Decline</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Manage Staff -->
            <div id="manage-staff">
                <div class="bg-gray-700 text-white font-semibold rounded-t px-4 py-2">Manage Staff</div>
                <ul class="bg-gray-300 text-gray-800 rounded-b">
                    <?php if (!empty($staff_users)): ?>
                        <?php foreach ($staff_users as $user): ?>
                            <li class="px-4 py-2 border-b flex items-center justify-between">
                                <span><?php echo $user['FullName']; ?></span>
                                <button onclick="confirmDelete(<?php echo $user['UserID']; ?>, '<?php echo addslashes($user['FullName']); ?>')" class="text-gray-500 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="px-4 py-2 text-gray-500">No staff available to manage.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirm-delete-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-yellow-500 rounded-lg p-6 w-full max-w-md text-center shadow-lg transform scale-105">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Confirm Deletion</h2>
            <p class="text-gray-800 mb-6">Are you sure you want to delete <span id="delete-user-name" class="font-semibold text-gray-900"></span>?</p>
            <form method="POST" action="adminMu.php">
                <input type="hidden" name="delete_id" id="delete-user-id">
                <div class="flex justify-center gap-4">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">Delete</button>
                    <button type="button" onclick="closeModal()" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>