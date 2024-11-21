<?php
// faculty.php 

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
    <title>Manage Users - All Faculty</title>
    <!-- Include Tailwind CSS and other styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminVa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
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

    <!-- Include Modal -->
    <?php include 'modal_faculty.php'; ?>

    <!-- JavaScript Code -->
    <script>
        $(document).ready(function() {
            let deleteUserId = null;

            // Function to fetch and display faculty members
            function fetchFaculty(query = '') {
                $.ajax({
                    url: 'faculty_handler.php',
                    method: 'GET',
                    data: { query: query },
                    dataType: 'json',
                    success: function(data) {
                        $('#faculty-table').html('');
                        if (data.length > 0) {
                            $.each(data, function(index, faculty) {
                                let facultyRow = `
                                    <div class="grid grid-cols-12 gap-4 items-center p-4 border-b">
                                        <div class="col-span-1">${faculty.UserID}</div>
                                        <div class="col-span-3">${faculty.Name}</div>
                                        <div class="col-span-3">${faculty.Campus}</div>
                                        <div class="col-span-2">${faculty.UserType}</div>
                                        <button class="delete-btn col-span-3 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700" data-id="${faculty.UserID}">
                                            Delete
                                        </button>
                                    </div>
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

            // Initial fetch
            fetchFaculty();

            // Search functionality
            $('#search').on('input', function() {
                let query = $(this).val();
                fetchFaculty(query);
            });

            // Show modal on delete button click
            $('#faculty-table').on('click', '.delete-btn', function() {
                deleteUserId = $(this).data('id');
                $('#modal-confirm-delete').removeClass('hidden');
            });

            // Handle delete confirmation
            $('#confirm-delete').on('click', function() {
                if (deleteUserId) {
                    $.ajax({
                        url: 'faculty_handler.php',
                        method: 'POST',
                        data: { user_id: deleteUserId },
                        success: function(response) {
                            alert(response);
                            fetchFaculty($('#search').val());
                            $('#modal-confirm-delete').addClass('hidden');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting faculty:', error);
                        }
                    });
                }
            });

            // Handle cancel
            $('#cancel-delete').on('click', function() {
                $('#modal-confirm-delete').addClass('hidden');
            });
        });
    </script>
</body>
</html>
