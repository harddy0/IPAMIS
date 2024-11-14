<?php
// or.php

// Display all errors for debugging purposes (Disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../includes/db_connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/adminMipa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="overflow-hidden bg-gray-100">

    <!-- Sidebar -->
    <div class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg">
        <?php include '../includes/dashboard.php'; ?>
    </div>

    <!-- Main Content Area -->
    <div class="ml-64 flex-grow overflow-y-auto">
        <!-- Header -->
        <?php include '../includes/header.php'; ?>

        <div class="dashboard p-6">
            <h2 class="text-2xl font-semibold text-blue-900 mb-6">OR</h2>

            <!-- Search Field with Suggestions -->
            <div class="mb-4 relative">
                <label class="block text-gray-700 font-semibold mb-2">Search for SOA Reference Code</label>
                <input type="text" id="search-input" placeholder="Type SOA Reference Code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300" autocomplete="off">
                <div id="suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
            </div>

            <!-- Form Fields -->
            <form method="POST" enctype="multipart/form-data" action="upload_or.php" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Invention Disclosure Code</label>
                    <input type="text" id="invention-id" name="InventionDisclosureCode" readonly class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Inventor</label>
                    <input type="text" id="inventor" name="Inventor" readonly class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">OR Reference Code</label>
                    <input type="text" id="reference-code" name="ReferenceCode" readonly class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Date Received</label>
                    <input type="text" id="date-received" name="DateReceived" placeholder="MM/DD/YYYY" class="date-picker w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300" readonly>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Upload New OR</label>
                    <label class="flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-lg cursor-pointer hover:bg-green-600">
                        <span>Select File</span>
                        <input type="file" name="file" accept=".pdf" class="hidden" id="file-input" disabled>
                    </label>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" id="upload-btn" class="flex-1 bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600" disabled>Upload</button>
                    <button type="button" id="clear-btn" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400">Clear</button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const suggestionsContainer = document.getElementById('suggestions');
            const inventionIdField = document.getElementById('invention-id');
            const inventorField = document.getElementById('inventor');
            const referenceCodeField = document.getElementById('reference-code');
            const dateReceivedField = document.getElementById('date-received');
            const fileInput = document.getElementById('file-input');
            const uploadBtn = document.getElementById('upload-btn');
            const clearBtn = document.getElementById('clear-btn');

            let debounceTimeout = null;

            // Event listener for input in search bar with debounce
            searchInput.addEventListener('input', function() {
                const referenceCode = this.value.trim();

                // Clear any existing debounce timeout
                clearTimeout(debounceTimeout);

                if (referenceCode.length > 0) {
                    debounceTimeout = setTimeout(() => {
                        fetchSuggestions(referenceCode);
                    }, 300);
                } else {
                    hideSuggestions();
                    resetForm();
                }
            });

            // Fetch suggestions from the server
            function fetchSuggestions(referenceCode) {
                suggestionsContainer.innerHTML = `<div class="px-4 py-2 text-gray-600">Loading...</div>`;
                suggestionsContainer.classList.remove('hidden');

                fetch(`or_search.php?referenceCode=${encodeURIComponent(referenceCode)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.suggestions.length > 0) {
                                showSuggestions(data.suggestions);
                            } else {
                                showNoResults();
                            }
                        } else {
                            console.error('Server error:', data.message);
                            showNoResults();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        showNoResults();
                    });
            }

            function showSuggestions(suggestionsData) {
                suggestionsContainer.innerHTML = ''; 

                suggestionsData.forEach(item => {
                    const div = document.createElement('div');
                    div.textContent = `${item.referenceCode} by ${item.inventor}`;
                    div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                    div.dataset.id = item.id;
                    div.dataset.inventor = item.inventor;
                    div.dataset.referenceCode = item.referenceCode;
                    div.onclick = () => selectSuggestion(item);
                    suggestionsContainer.appendChild(div);
                });

                suggestionsContainer.classList.remove('hidden');
            }

            function showNoResults() {
                suggestionsContainer.innerHTML = '<div class="px-4 py-2 text-gray-500">No results found.</div>';
                suggestionsContainer.classList.remove('hidden');
            }

            function hideSuggestions() {
                suggestionsContainer.classList.add('hidden');
            }

            function selectSuggestion(item) {
                searchInput.value = item.referenceCode;
                inventionIdField.value = item.id;
                inventorField.value = item.inventor;
                referenceCodeField.value = item.referenceCode;

                referenceCodeField.readOnly = false;
                dateReceivedField.readOnly = false;
                fileInput.disabled = false;
                uploadBtn.disabled = false;

                hideSuggestions();
            }

            function resetForm() {
                inventionIdField.value = '';
                inventorField.value = '';
                referenceCodeField.value = '';
                referenceCodeField.readOnly = true;
                dateReceivedField.value = '';
                dateReceivedField.readOnly = true;
                fileInput.disabled = true;
                uploadBtn.disabled = true;
            }

            // Event listener for the Clear button
            clearBtn.addEventListener('click', function() {
                inventorField.value = '';
                referenceCodeField.value = '';
                dateReceivedField.value = '';
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.relative')) {
                    hideSuggestions();
                }
            });

            flatpickr('.date-picker', {
                dateFormat: 'm/d/Y',
                allowInput: true
            });
        });
    </script>
</body>
</html>
