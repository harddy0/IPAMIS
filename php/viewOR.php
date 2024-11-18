<?php
// manage_or.php

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
    <title>Manage Official Receipt (OR)</title>
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
            <h2 class="text-2xl font-semibold text-blue-900 mb-6">Manage Official Receipt (OR)</h2>

            <!-- Search Field with Suggestions -->
            <div class="mb-4 relative">
                <label class="block text-gray-700 font-semibold mb-2">Search by OR Reference Code</label>
                <input type="text" id="search-or-input" placeholder="Type OR reference code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300" autocomplete="off">
                <div id="or-suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
            </div>

            <!-- Details -->
            <div id="or-details" class="hidden space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold">Invention Disclosure Code:</label>
                    <input type="text" id="or-invention-code" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-200" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Inventor:</label>
                    <input type="text" id="or-inventor" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-200" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">Date Added:</label>
                    <input type="text" id="or-date-added" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-200" readonly>
                </div>
            </div>

            <!-- Action buttons for download and delete -->
            <div id="or-actions" class="hidden space-x-4 mt-4">
                <button id="download-or-btn" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600">Download</button>
                <button id="delete-or-btn" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600">Delete</button>
            </div>
        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchORInput = document.getElementById('search-or-input');
    const orSuggestions = document.getElementById('or-suggestions');
    const orDetails = document.getElementById('or-details');
    const orInventionCode = document.getElementById('or-invention-code');
    const orInventor = document.getElementById('or-inventor');
    const orDateAdded = document.getElementById('or-date-added');
    const downloadORBtn = document.getElementById('download-or-btn');
    const deleteORBtn = document.getElementById('delete-or-btn');
    const orActions = document.getElementById('or-actions');
    let selectedORReference = '';

    // Event listener for search input
    searchORInput.addEventListener('input', function () {
        const reference = this.value.trim();
        if (reference.length > 0) {
            fetch(`or_search_download.php?query=${encodeURIComponent(reference)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displaySuggestions(data.suggestions);
                    } else {
                        hideSuggestions();
                    }
                })
                .catch(error => console.error('Error fetching OR suggestions:', error));
        } else {
            hideSuggestions();
        }
    });

    // Display suggestions
    function displaySuggestions(suggestions) {
        orSuggestions.innerHTML = '';
        const uniqueSuggestions = Array.from(new Map(suggestions.map(item => [item.reference_code, item])).values());
        uniqueSuggestions.forEach(item => {
            const div = document.createElement('div');
            div.textContent = item.reference_code;
            div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
            div.onclick = () => selectORReference(item);
            orSuggestions.appendChild(div);
        });
        orSuggestions.classList.remove('hidden');
    }

    // Select an OR reference
    function selectORReference(data) {
        selectedORReference = data.reference_code;
        searchORInput.value = selectedORReference;
        orInventionCode.value = data.invention_code;
        orInventor.value = data.inventor;
        orDateAdded.value = data.date_added;
        orActions.classList.remove('hidden');
        orDetails.classList.remove('hidden');
        hideSuggestions();
    }

    // Hide suggestions
    function hideSuggestions() {
        orSuggestions.classList.add('hidden');
    }

    // Download OR file
    downloadORBtn.addEventListener('click', function () {
        if (selectedORReference) {
            window.location.href = `or_search_download.php?reference=${encodeURIComponent(selectedORReference)}&action=download`;
        } else {
            alert('Please select an OR to download.');
        }
    });

    // Delete OR record
    deleteORBtn.addEventListener('click', function () {
        if (selectedORReference && confirm('Are you sure you want to delete this OR? This action cannot be undone.')) {
            fetch(`or_search_download.php?reference=${encodeURIComponent(selectedORReference)}&action=delete`)
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        resetForm();
                    }
                })
                .catch(error => console.error('Error deleting OR:', error));
        } else {
            alert('Please select an OR to delete.');
        }
    });

    // Reset form fields
    function resetForm() {
        selectedORReference = '';
        orActions.classList.add('hidden');
        orDetails.classList.add('hidden');
        searchORInput.value = '';
        hideSuggestions();
    }
});
</script>

</body>
</html>