<?php
// formality.php

// Display all errors for debugging purposes
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
    <title>Formality Report</title>
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
            <h2 class="text-2xl font-semibold text-blue-900 mb-6">Formality Report</h2>

            <!-- Search Field with Suggestions -->
            <div class="mb-4 relative">
                <label class="block text-gray-700 font-semibold mb-2">Search for OR Reference Code</label>
                <input type="text" id="search-input" placeholder="Type OR reference code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300" autocomplete="off">
                <div id="suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
            </div>

            <!-- Form Fields -->
            <form method="POST" enctype="multipart/form-data" action="upload_formality.php" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Invention Disclosure Code</label>
                    <input type="text" id="invention-id" name="InventionDisclosureCode" readonly class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Inventor</label>
                    <input type="text" id="inventor" name="Inventor" readonly class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Formality Report Reference Code</label>
                    <input type="text" id="reference-code" name="ReferenceCode" readonly class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Date Received</label>
                    <input type="text" id="date-received" name="DateReceived" placeholder="MM/DD/YYYY" readonly class="date-picker w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Upload New Formality Report</label>
                    <label class="custom-file-input block mt-2 mb-4 relative bg-green-500 text-white text-center rounded-lg px-4 py-2 cursor-pointer">
                        <input type="file" name="file" class="hidden" accept=".pdf" onchange="this.nextElementSibling.innerText = this.files[0].name" required>
                        <span>Select File</span>
                    </label>
                </div>

                <button type="submit" id="upload-btn" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">Upload</button>
                <button type="button" id="clear-btn" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400 mt-2">Clear</button>
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
            const fileInput = document.querySelector('input[name="file"]');
            const uploadBtn = document.getElementById('upload-btn');
            const clearBtn = document.getElementById('clear-btn');

            let debounceTimeout = null;

            searchInput.addEventListener('input', function() {
                const title = this.value.trim();

                clearTimeout(debounceTimeout);

                if (title.length > 0) {
                    debounceTimeout = setTimeout(() => {
                        fetchSuggestions(title);
                    }, 300);
                } else {
                    hideSuggestions();
                    resetForm();
                }
            });

            function fetchSuggestions(title) {
                suggestionsContainer.innerHTML = `<div class="px-4 py-2 text-gray-600">Loading...</div>`;
                suggestionsContainer.classList.remove('hidden');

                fetch(`formality_search.php?title=${encodeURIComponent(title)}`)
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
                    div.textContent = `${item.title} by ${item.inventor}`;
                    div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                    div.dataset.id = item.id;
                    div.dataset.title = item.title;
                    div.dataset.inventor = item.inventor;
                    div.dataset.referenceCode = item.reference_code;
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
                searchInput.value = item.title;
                inventionIdField.value = item.id;
                inventorField.value = item.inventor;
                referenceCodeField.value = item.reference_code;

                referenceCodeField.readOnly = false;
                dateReceivedField.readOnly = false;
                fileInput.disabled = false;
                uploadBtn.disabled = false;

                hideSuggestions();
            }

            function resetForm() {
                inventorField.value = '';
                referenceCodeField.value = '';
                referenceCodeField.readOnly = true;
                dateReceivedField.value = '';
                dateReceivedField.readOnly = true;
                fileInput.disabled = true;
                uploadBtn.disabled = true;
            }

            clearBtn.addEventListener('click', resetForm);

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.relative')) {
                    hideSuggestions();
                }
            });

            flatpickr('.date-picker', {
                dateFormat: 'm/d/Y'
            });
        });
    </script>
</body>
</html>
