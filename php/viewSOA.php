<?php
// manage_soa.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View IP Assets - SOA</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body class="overflow-hidden bg-gray-100">

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
        <div class="dashboard p-6">
            <h2 class="text-2xl font-semibold text-blue-900 mb-6">View IP Assets - SOA</h2>

            <!-- Search Field -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Search</label>
                <input type="text" id="search-soa-input" placeholder="Search by Inventor or SOA Code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-blue-900 text-white text-left">
                            <th class="px-4 py-2">Invention Code</th>
                            <th class="px-4 py-2">Inventor</th>
                            <th class="px-4 py-2">SOA Code</th>
                            <th class="px-4 py-2">SOA File/Title</th>
                            <th class="px-4 py-2">Date Upload</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="soa-table-body" class="text-gray-700">
                        <!-- Dynamic content will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-soa-input');
    const soaTableBody = document.getElementById('soa-table-body');

    // Function to load SOA data dynamically
    function loadSOAData(query = '') {
        fetch(`soa_search_download.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderTableRows(data.records);
                } else {
                    soaTableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">No records found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching SOA data:', error));
    }

    // Render table rows
    function renderTableRows(records) {
        soaTableBody.innerHTML = '';
        records.forEach(record => {
            const row = `
                <tr class="border-t hover:bg-gray-100">
                    <td class="px-4 py-2">${record.invention_code}</td>
                    <td class="px-4 py-2">${record.inventor}</td>
                    <td class="px-4 py-2">${record.soa_code}</td>
                    <td class="px-4 py-2">
                        <a href="soa_search_download.php?reference=${encodeURIComponent(record.soa_code)}&action=download" class="text-blue-500 hover:underline flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Download
                        </a>
                    </td>
                    <td class="px-4 py-2">${record.date_added}</td>
                    <td class="px-4 py-2">
                        <button onclick="confirmDelete('${record.soa_code}')" class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
            `;
            soaTableBody.innerHTML += row;
        });
    }

    // Confirm and Delete SOA
    window.confirmDelete = function(soaCode) {
        if (confirm('Are you sure you want to delete this SOA? This action cannot be undone.')) {
            deleteSOA(soaCode);
        }
    }

    function deleteSOA(soaCode) {
        fetch(`soa_search_download.php?reference=${encodeURIComponent(soaCode)}&action=delete`, {
            method: 'GET',
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    loadSOAData(searchInput.value.trim());
                }
            })
            .catch(error => console.error('Error deleting SOA:', error));
    }

    // Event listener for search input
    searchInput.addEventListener('input', function () {
        loadSOAData(this.value.trim());
    });

    // Initial load
    loadSOAData();
});
</script>

</body>
</html>
