<?php
// manage_faculty.php

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
include '../includes/db_connect.php';

// Optional: Include any session checks or authorization here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (existing head content) ... -->
    <title>Manage Users - All Faculty</title>
    <!-- Include Tailwind CSS and other styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- ... (other CSS links) ... -->
    <!-- Include jQuery for AJAX (you can also use vanilla JS or Fetch API) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include your custom CSS files -->
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminVa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
    .scroll {
        scrollbar-width: thin; /* Firefox */
        scrollbar-color: #1d4ed8 #f3f4f6; /* Firefox */
    }
    .scroll::-webkit-scrollbar {
        width: 8px; /* Scrollbar width */
    }
    .scroll::-webkit-scrollbar-thumb {
        background-color: #1d4ed8; /* Scrollbar thumb color */
        border-radius: 4px;
    }
    .scroll::-webkit-scrollbar-track {
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
                    Manage Users - All Faculty
                </h1>
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-blue-900 text-white py-3 px-6 rounded-t-lg flex justify-center items-center">
                        <h2 class="text-xl font-semibold">All Faculty</h2>
                    </div>
                </div>

                <div class="p-6 bg-blue-100">
                    <!-- Search Bar -->
                    <div class="relative mb-4 flex items-center">
                        <input
                            id="search"
                            type="text"
                            placeholder="Search"
                            class="w-full p-3 pl-10 text-black rounded-l-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-500"
                        />
                        <button id="search-btn" class="bg-blue-500 text-white p-3 rounded-r-md hover:bg-blue-700 transition duration-200">
                            Search
                        </button>
                    </div>

                    <!-- Table Header -->
                    <div class="grid grid-cols-12 gap-4 items-center bg-blue-800 text-white px-4 py-2 rounded-t-lg">
                        <div class="col-span-1">ID Number</div>
                        <div class="col-span-3">Name</div>
                        <div class="col-span-3">Campus</div>
                        <div class="col-span-2">User Type</div>
                        <div class="col-span-3">Action</div>
                    </div>

                    <!-- Scrollable Form Container -->
                    <div id="faculty-table" class="scroll overflow-y-auto max-h-64 space-y-4 bg-white rounded-b-lg">
                        <!-- Faculty records will be injected here via JavaScript -->
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

    <!-- JavaScript Code -->
    <script>
        $(document).ready(function() {
            // Function to fetch and display faculty members
            function fetchFaculty(query = '') {
                $.ajax({
                    url: 'faculty_handler.php',
                    method: 'GET',
                    data: { query: query },
                    dataType: 'json',
                    success: function(data) {
                        // Clear the table
                        $('#faculty-table').html('');
                        if (data.length > 0) {
                            $.each(data, function(index, faculty) {
                                let facultyRow = `
                                    <form class="grid grid-cols-12 gap-4 items-center p-4 border-b">
                                        <input type="text" value="${faculty.UserID}" class="col-span-1 px-4 py-2 border rounded-md" readonly />
                                        <input type="text" value="${faculty.Name}" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                                        <input type="text" value="${faculty.Campus}" class="col-span-3 px-4 py-2 border rounded-md" readonly />
                                        <input type="text" value="${faculty.UserType}" class="col-span-2 px-4 py-2 border rounded-md" readonly />
                                        <button type="button" class="delete-btn col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700" data-id="${faculty.UserID}">
                                            Delete
                                        </button>
                                    </form>
                                `;
                                $('#faculty-table').append(facultyRow);
                            });
                        } else {
                            $('#faculty-table').html('<div class="p-4">No faculty members found.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching faculty:', error);
                    }
                });
            }

            // Initial fetch of all faculty members
            fetchFaculty();

            // Search functionality
            $('#search').on('input', function() {
                let query = $(this).val();
                fetchFaculty(query);
            });

            // Delete functionality (delegated event handler)
            $('#faculty-table').on('click', '.delete-btn', function() {
                let userId = $(this).data('id');
                if (confirm('Are you sure you want to delete this faculty member?')) {
                    $.ajax({
                        url: 'faculty_handler.php',
                        method: 'POST',
                        data: { user_id: userId },
                        success: function(response) {
                            alert(response);
                            fetchFaculty($('#search').val());
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting faculty:', error);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
