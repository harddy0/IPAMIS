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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openModal(userId, userName) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modalUserName').innerText = userName;
            document.getElementById('confirmDeleteBtn').onclick = function () {
                window.location.href = `adminMu.php?deactivate_id=${userId}`;
            };
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        // AJAX search functionality
        function searchStaff() {
            var searchQuery = $('#search-bar').val();
            $.ajax({
                url: 'searchStaff.php',
                method: 'GET',
                data: { query: searchQuery },
                success: function(response) {
                    $('#search-results').html(response).removeClass('hidden');
                }
            });
        }

        $(document).ready(function() {
            $('#search-bar').on('input', function() {
                if ($(this).val().length > 0) {
                    searchStaff();
                } else {
                    $('#search-results').addClass('hidden');
                }
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#search-bar, #search-results').length) {
                    $('#search-results').addClass('hidden');
                }
            });
        });
    </script>
</head>
<body>
    <?php
    include '../includes/db_connect.php';

    if (isset($_GET['deactivate_id'])) {
        $deactivate_id = intval($_GET['deactivate_id']);
        $stmt = $conn->prepare("UPDATE user SET Status = 'Inactive' WHERE UserID = ?");
        $stmt->bind_param("i", $deactivate_id);
        $stmt->execute();
        $stmt->close();
        header("Location: adminMu.php");
        exit();
    }

    $staff_query = "SELECT UserID, CONCAT(FirstName, ' ', LastName) AS FullName FROM user WHERE UserType = 'Staff' AND Status = 'Active'";
    $staff_result = $conn->query($staff_query);
    $staff_users = $staff_result ? $staff_result->fetch_all(MYSQLI_ASSOC) : [];
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
                <input type="text" id="search-bar" class="bg-gray-300 rounded-full py-2 px-4 text-gray-700" placeholder="Search">
                <button class="absolute right-2 top-2 text-gray-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
                        <line x1="16.65" y1="16.65" x2="21" y2="21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                    </svg>
                </button>
                <ul id="search-results" class="absolute bg-white border rounded w-full mt-1 hidden z-10"></ul>
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
                                <a href="adminEditStaff.php?user_id=<?php echo $user['UserID']; ?>" class="text-blue-600 hover:underline">
                                    <?php echo htmlspecialchars($user['UserID'] . " - " . $user['FullName']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="px-4 py-2 text-gray-500">No active staff found.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Middle Column: Faculty Requests -->
            <div id="faculty-requests">
                <div class="bg-blue-700 text-white font-semibold rounded-t px-4 py-2 flex items-center justify-between">
                    Faculty Request
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a7 7 0 00-7 7v3.5l-1.26 2.52A1 1 0 005 17h14a1 1 0 00.86-1.48L18 12.5V9a7 7 0 00-7-7zm1 16h-2a2 2 0 004 0h-2z"></path>
                    </svg>
                </div>
                <div class="bg-gray-300 rounded-b p-2">
                    <div class='px-4 py-2 flex items-center justify-between'>
                        <span>Shekinah Olarte</span>
                        <div>
                            <button class='bg-yellow-500 text-white font-bold px-2 py-1 rounded mr-2 hover:bg-yellow-600'>Accept</button>
                            <button class='bg-gray-500 text-white font-bold px-2 py-1 rounded hover:bg-gray-600'>Decline</button>
                        </div>
                    </div>
                    <div class='px-4 py-2 flex items-center justify-between'>
                        <span>Dahlia Genson</span>
                        <div>
                            <button class='bg-yellow-500 text-white font-bold px-2 py-1 rounded mr-2 hover:bg-yellow-600'>Accept</button>
                            <button class='bg-gray-500 text-white font-bold px-2 py-1 rounded hover:bg-gray-600'>Decline</button>
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
                                <a href="adminEditStaff.php?user_id=<?php echo $user['UserID']; ?>" class="text-blue-600 hover:underline">
                                    <?php echo htmlspecialchars($user['FullName']); ?>
                                </a>
                                <button onclick="openModal(<?php echo $user['UserID']; ?>, '<?php echo addslashes($user['FullName']); ?>')" class="text-gray-500 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="px-4 py-2 text-gray-500">No active staff available to manage.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Deactivate Confirmation Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-80 text-center border-t-4 border-yellow-500">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Confirm Deactivation</h2>
            <p class="text-gray-700 mb-6">Are you sure you want to deactivate <span id="modalUserName" class="font-semibold"></span>?</p>
            <div class="flex justify-between">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Deactivate</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>