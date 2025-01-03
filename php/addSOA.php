<?php
// addSoa.php

// Display all errors for debugging purposes (Disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../includes/db_connect.php';
session_start();

// Function to generate a random IPAssetCode (e.g., 12-character alphanumeric)
function generateRandomCode($length = 12) {
    return substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', ceil($length/62))), 0, $length);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['InventionDisclosureCode']) && isset($_POST['ReferenceCode']) && isset($_POST['DateReceived'])) {
    $inventionDisclosureCode = $_POST['InventionDisclosureCode'];
    $referenceCode = $_POST['ReferenceCode'];
    $dateReceived = $_POST['DateReceived'];
    $currentUser = $_SESSION['FirstName'];
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate form inputs
    if (empty($inventionDisclosureCode) || empty($referenceCode) || empty($dateReceived) || $fileExtension !== 'pdf') {
        // Set $modalMessage to the error message
        $modalMessage = 'All fields are required, and the file must be a PDF.';
    } else {
        // Check if the SOA Reference Code already exists in the database
        $soaCheckStmt = $conn->prepare("SELECT SOAReference FROM statementofaccount WHERE SOAReference = ?");
        $soaCheckStmt->bind_param("s", $referenceCode);
        $soaCheckStmt->execute();
        $soaCheckStmt->store_result();

        if ($soaCheckStmt->num_rows > 0) {
            // SOA Reference Code already exists
            $modalMessage = 'A SOA with this Reference Code already exists.';
        } else {
            // Read file content
            $fileContent = file_get_contents($fileTmpPath);

            if ($fileContent === false) {
                $modalMessage = 'Failed to read the uploaded file.';
            } else {
                // Begin transaction
                $conn->begin_transaction();

                try {
                    // Insert into statementofaccount table
                    $stmt = $conn->prepare("INSERT INTO statementofaccount (SOAReference, InventionDisclosureCode, IPOPHLReceivedDate, SOA) VALUES (?, ?, ?, ?)");
                    $null = NULL;
                    $stmt->bind_param("sssb", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                    $stmt->send_long_data(3, $fileContent);
                    $stmt->execute();
                    $stmt->close();

                    // Update invention_disclosure table with the new SOA reference code
                    $updateDisclosure = $conn->prepare("UPDATE invention_disclosure SET soa_reference_number = ? WHERE id = ?");
                    $updateDisclosure->bind_param("si", $referenceCode, $inventionDisclosureCode);
                    $updateDisclosure->execute();
                    $updateDisclosure->close();

                    // Check if an entry exists in ipasset table
                    $ipassetCheck = $conn->prepare("SELECT IPAssetCode FROM ipasset WHERE InventionDisclosureCode = ?");
                    $ipassetCheck->bind_param("s", $inventionDisclosureCode);
                    $ipassetCheck->execute();
                    $ipassetCheck->store_result();

                    if ($ipassetCheck->num_rows > 0) {
                        // If entry exists, update it with SOA details
                        $updateIpAsset = $conn->prepare("UPDATE ipasset SET SOARefCode = ?, SOAAddedBy = ? WHERE InventionDisclosureCode = ?");
                        $updateIpAsset->bind_param("sss", $referenceCode, $currentUser, $inventionDisclosureCode);
                        $updateIpAsset->execute();
                        $updateIpAsset->close();
                    } else {
                        // Otherwise, insert a new entry in ipasset
                        $newIPAssetCode = generateRandomCode();
                        $insertIpAsset = $conn->prepare("INSERT INTO ipasset (IPAssetCode, InventionDisclosureCode, SOARefCode, SOAAddedBy) VALUES (?, ?, ?, ?)");
                        $insertIpAsset->bind_param("ssss", $newIPAssetCode, $inventionDisclosureCode, $referenceCode, $currentUser);
                        $insertIpAsset->execute();
                        $insertIpAsset->close();
                    }

                    // Commit transaction
                    $conn->commit();
                    $modalMessage = 'File uploaded successfully!';
                } catch (Exception $e) {
                    // Rollback on error
                    $conn->rollback();
                    $modalMessage = 'Error uploading file: ' . $e->getMessage();
                }
            }
        }

        $soaCheckStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content remains the same -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add SOA</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <!-- Include your custom CSS if any -->
    <link rel="stylesheet" href="../css/adminVa.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

            <!-- Main Content Here-->
            <div class="p-6">

                <h2 class="text-3xl font-bold text-blue-900 mb-6">Statement of Account</h2>

                <!-- Search Field with Suggestions -->
                <div class="mb-6 relative">
                    <label class="block text-gray-800 font-semibold mb-2">Search for Invention Title</label>
                    <input type="text" id="search-input" placeholder="Type title of invention..." class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
                    <div id="suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
                </div>

                <!-- Form Fields -->
                <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-xl">
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Invention Disclosure Code</label>
                        <input type="text" id="invention-id" name="InventionDisclosureCode" readonly class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Inventor</label>
                        <input type="text" id="inventor" name="Inventor" readonly class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">SOA Reference Code</label>
                        <input type="text" id="reference-code" name="ReferenceCode" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Date Received</label>
                        <input type="text" id="date-received" name="DateReceived" placeholder="MM/DD/YYYY" required class="date-picker w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Updated Upload New SOA Section -->
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Upload New SOA</label>
                        <div class="flex items-center">
                            <label for="file-input" class="bg-gradient-to-r from-green-400 to-green-600 text-white text-center py-2 px-6 rounded-lg cursor-pointer hover:from-green-500 hover:to-green-700 transition duration-200 ease-in-out">
                                Choose File
                            </label>
                            <span id="file-name" class="ml-4 text-gray-600">No file selected</span>
                        </div>
                        <input type="file" id="file-input" name="file" accept=".pdf" class="hidden" required>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" id="upload-btn" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-800 transition duration-200 ease-in-out">
                            Upload
                        </button>
                        <button type="button" id="clear-btn" class="w-full bg-gradient-to-r from-gray-400 to-gray-500 text-white py-3 rounded-lg font-semibold hover:from-gray-500 hover:to-gray-600 transition duration-200 ease-in-out">
                            Clear
                        </button>
                    </div>
                </form>

            </div>

            <?php include '../includes/footer.php'; ?>

        </div>
    </div>

    <!-- Include modal.php -->
    <?php include 'modal.php'; ?>

    <!-- Existing Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize the date picker
            flatpickr('#date-received', {
                dateFormat: 'm/d/Y'
            });

            // Get DOM elements
            const searchInput = document.getElementById('search-input');
            const suggestionsContainer = document.getElementById('suggestions');
            const inventionIdField = document.getElementById('invention-id');
            const inventorField = document.getElementById('inventor');
            const referenceCodeField = document.getElementById('reference-code');
            const fileInput = document.getElementById('file-input');
            const fileNameDisplay = document.getElementById('file-name');
            const clearBtn = document.getElementById('clear-btn');

            let debounceTimeout = null;

            // Search input listener for suggestions
            searchInput.addEventListener('input', function () {
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

            // Fetch suggestions from the server
            function fetchSuggestions(title) {
                suggestionsContainer.innerHTML = `<div class="px-4 py-2 text-gray-600">Loading...</div>`;
                suggestionsContainer.classList.remove('hidden');

                fetch(`soa_search.php?title=${encodeURIComponent(title)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuggestions(data.suggestions);
                        } else {
                            showNoResults();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        showNoResults();
                    });
            }

            // Display suggestions in the dropdown
            function showSuggestions(suggestions) {
                suggestionsContainer.innerHTML = '';

                suggestions.forEach(item => {
                    const div = document.createElement('div');
                    div.textContent = `${item.title} by ${item.inventor}`;
                    div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                    div.dataset.id = item.id;
                    div.dataset.inventor = item.inventor;
                    div.onclick = () => selectSuggestion(item);
                    suggestionsContainer.appendChild(div);
                });

                suggestionsContainer.classList.remove('hidden');
            }

            // Show "No results found" message
            function showNoResults() {
                suggestionsContainer.innerHTML = '<div class="px-4 py-2 text-gray-500">No results found.</div>';
                suggestionsContainer.classList.remove('hidden');
            }

            // Hide suggestions dropdown
            function hideSuggestions() {
                suggestionsContainer.classList.add('hidden');
            }

            // Handle selection of a suggestion
            function selectSuggestion(item) {
                searchInput.value = item.title;
                inventionIdField.value = item.id;
                inventorField.value = item.inventor;

                // Ensure SOA Reference Code is always empty
                referenceCodeField.value = '';
                hideSuggestions();
            }

            // Handle file selection
            fileInput.addEventListener('change', function () {
                if (fileInput.files.length > 0) {
                    fileNameDisplay.textContent = `File: ${fileInput.files[0].name}`;
                } else {
                    fileNameDisplay.textContent = 'No file selected';
                }
            });

            // Reset the form to its default state
            function resetForm() {
                inventionIdField.value = '';
                inventorField.value = '';
                referenceCodeField.value = '';
                fileInput.value = '';
                fileNameDisplay.textContent = 'No file selected';
                searchInput.value = '';
            }

            // Clear form when the clear button is clicked
            clearBtn.addEventListener('click', resetForm);

            // Close modal when close button is clicked
            document.getElementById('modal-close').addEventListener('click', function () {
                document.getElementById('modal').classList.add('hidden');
            });

            <?php if (isset($modalMessage)) : ?>
                // Set the modal message and show it
                document.getElementById('modal-message').textContent = '<?php echo addslashes($modalMessage); ?>';
                document.getElementById('modal').classList.remove('hidden');
            <?php endif; ?>
        });
    </script>

</body>
</html>
