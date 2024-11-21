<?php
// adstaff.php

// Start the session
session_start();

// Include the database connection
include '../includes/db_connect.php';

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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
    #usersContainer {
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #1d4ed8 #f3f4f6; /* Firefox */
    }
    #usersContainer::-webkit-scrollbar {
        width: 8px; /* Scrollbar width */
    }
    #usersContainer::-webkit-scrollbar-thumb {
        background-color: #1d4ed8; /* Scrollbar thumb color */
        border-radius: 4px;
    }
    #usersContainer::-webkit-scrollbar-track {
        background-color: #f3f4f6; /* Scrollbar track color */
    }
</style>
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
                <h1 class="text-3xl font-bold text-blue-900 mb-6">
                    Manage Users - Admin & Staff
                </h1>
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-blue-900 text-white py-3 px-6 rounded-t-lg flex justify-center items-center">
                        <h2 class="text-xl font-semibold">Admin & Staff</h2>
                    </div>
                </div>

                <div class="p-6 bg-blue-100">
                    <div class="relative mb-4 flex items-center space-x-4">
                        <input
                            id="search"
                            type="text"
                            placeholder="Search by name"
                            class="w-4/5 p-3 pl-4 text-black rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-500"
                        />
                        <a
                            href="addUser.php"
                            class="inline-flex items-center justify-center bg-blue-500 text-white px-4 py-3 rounded-md hover:bg-blue-700 transition duration-200">
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
                    <div id="usersContainer" class="overflow-y-auto max-h-64 space-y-4 bg-white rounded-b-lg">
                        <!-- User records will be dynamically inserted here -->
                        <p class="p-4 text-gray-700">Loading users...</p>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

    <!-- Include Modal -->
    <?php include 'modal_staff.php'; ?>

    <!-- JavaScript for Live Search and Delete Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const usersContainer = document.getElementById('usersContainer');
            const deleteModal = document.getElementById('modal-confirm-delete');
            const confirmDeleteBtn = document.getElementById('confirm-delete');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            let deleteUserId = null;

            // Function to fetch and display users
            function fetchUsers(query = '') {
                usersContainer.innerHTML = '<p class="p-4 text-gray-700">Loading users...</p>';
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

            // Initial fetch
            fetchUsers();

            // Debounce function
            function debounce(func, delay) {
                let debounceTimer;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(context, args), delay);
                }
            }

            // Search functionality
            searchInput.addEventListener('input', debounce(function() {
                fetchUsers(this.value.trim());
            }, 300));

            // Delete button click (show modal)
            usersContainer.addEventListener('click', function(e) {
                if (e.target && e.target.matches('button.delete-button')) {
                    deleteUserId = e.target.getAttribute('data-userid');
                    deleteModal.classList.remove('hidden');
                }
            });

            // Confirm delete
            confirmDeleteBtn.addEventListener('click', function() {
                if (deleteUserId) {
                    axios.post('adstaff_handler.php', new URLSearchParams({
                        action: 'delete',
                        UserID: deleteUserId
                    }))
                    .then(function(response) {
                        if (response.data.success) {
                            fetchUsers(searchInput.value.trim());
                        } else {
                            console.error(response.data.message);
                        }
                        deleteModal.classList.add('hidden');
                    })
                    .catch(function(error) {
                        console.error('Error deleting user:', error);
                        deleteModal.classList.add('hidden');
                    });
                }
            });

            // Cancel delete
            cancelDeleteBtn.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
            });
        });
    </script>
</body>
</html>