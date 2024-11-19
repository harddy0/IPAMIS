<?php
// adstaff.php

// Start the session
session_start();

// Include the database connection
include '../includes/db_connect.php';

// Optional: Implement authentication checks here
// Example:
// if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
//     header('Location: login.php');
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin & Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminVa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <!-- Include Axios for AJAX requests -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="overflow-hidden">

    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-screen w-64">
            <?php include '../includes/dashboard.php'; ?>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper ml-64 flex-grow overflow-y-auto">
            <!-- Header -->
            <?php include '../includes/header.php'; ?>

            <!-- Main Content -->
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">
                    Manage Users - Admin & Staff
                </h1>
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-blue-900 text-white py-3 px-6 rounded-t-lg flex justify-center items-center">
                        <h2 class="text-xl font-semibold">Admin & Staff</h2>
                    </div>
                </div>

                <div class="p-6 bg-gray-100">
                    <div class="relative mb-4 flex items-center space-x-4">
                        <input
                            id="search"
                            type="text"
                            placeholder="Search by name"
                            class="w-4/5 p-3 pl-4 text-black rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-500"
                        />
                        <a
                            href="addUser.php"
                            class="inline-flex items-center justify-center bg-green-500 text-white px-4 py-3 rounded-md hover:bg-green-700 transition duration-200">
                            Add User
                        </a>
                    </div>

                    <!-- Header -->
                    <div class="grid grid-cols-12 gap-4 items-center bg-blue-800 text-white px-4 py-2 rounded-t-lg">
                        <div class="col-span-1">ID Number</div>
                        <div class="col-span-2">Name</div>
                        <div class="col-span-2">User Type</div>
                        <div class="col-span-2">Campus</div>
                        <div class="col-span-2">Department</div>
                        <div class="col-span-2">Email</div>
                        <div class="col-span-1 text-center">Action</div>
                    </div>

                    <!-- Scrollable Form Container -->
                    <div id="usersContainer" class="overflow-y-auto max-h-96 space-y-4 bg-white rounded-b-lg">
                        <!-- User records will be dynamically inserted here -->
                        <p class="p-4 text-gray-700">Loading users...</p>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

    <!-- JavaScript for Live Search and Delete Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const usersContainer = document.getElementById('usersContainer');

            // Function to fetch and display users based on the search query
            function fetchUsers(query = '') {
                // Display loading message
                usersContainer.innerHTML = '<p class="p-4 text-gray-700">Loading users...</p>';

                // Use URLSearchParams to send form data
                axios.post('adstaff_handler.php', new URLSearchParams({
                    action: 'search',
                    query: query
                }))
                .then(function(response) {
                    usersContainer.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.error('Error fetching users:', error);
                    usersContainer.innerHTML = '<p class="p-4 text-red-500">An error occurred while fetching users.</p>';
                });
            }

            // Initial fetch to display all users
            fetchUsers();

            // Debounce function to limit the rate of function calls
            function debounce(func, delay) {
                let debounceTimer;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(context, args), delay);
                }
            }

            // Event listener for live search (on input with debounce)
            searchInput.addEventListener('input', debounce(function() {
                const query = this.value.trim();
                fetchUsers(query);
            }, 300)); // 300ms delay

            // Event delegation for delete buttons
            usersContainer.addEventListener('click', function(e) {
                if (e.target && e.target.matches('button.delete-button')) {
                    const userId = e.target.getAttribute('data-userid');
                    const confirmDelete = confirm('Are you sure you want to delete this user?');
                    if (confirmDelete) {
                        // Send delete request via Axios
                        axios.post('adstaff_handler.php', new URLSearchParams({
                            action: 'delete',
                            UserID: userId
                        }))
                        .then(function(response) {
                            if (response.data.success) {
                                alert('User deleted successfully.');
                                // Refresh the user list
                                const currentQuery = searchInput.value.trim();
                                fetchUsers(currentQuery);
                            } else {
                                alert('Error deleting user: ' + response.data.message);
                            }
                        })
                        .catch(function(error) {
                            console.error('Error deleting user:', error);
                            alert('An error occurred while deleting the user.');
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
