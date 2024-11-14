<?php
// or.php

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
        echo "<script>alert('All fields are required, and the file must be a PDF.');</script>";
    } else {
        // Read file content
        $fileContent = file_get_contents($fileTmpPath);

        if ($fileContent === false) {
            echo "<script>alert('Failed to read the uploaded file.');</script>";
        } else {
            // Begin transaction
            $conn->begin_transaction();

            try {
                // Insert into electronicor table
                $stmt = $conn->prepare("INSERT INTO electronicor (eORNumber, InventionDisclosureCode, eORDate, eOR) VALUES (?, ?, ?, ?)");
                $null = NULL;
                $stmt->bind_param("sssb", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                $stmt->send_long_data(3, $fileContent);
                $stmt->execute();
                $stmt->close();

                // Update invention_disclosure table with the new OR reference code
                $updateDisclosure = $conn->prepare("UPDATE invention_disclosure SET eor_number = ? WHERE id = ?");
                $updateDisclosure->bind_param("si", $referenceCode, $inventionDisclosureCode);
                $updateDisclosure->execute();
                $updateDisclosure->close();

                // Check if an entry exists in ipasset table
                $ipassetCheck = $conn->prepare("SELECT IPAssetCode FROM ipasset WHERE InventionDisclosureCode = ?");
                $ipassetCheck->bind_param("s", $inventionDisclosureCode);
                $ipassetCheck->execute();
                $ipassetCheck->store_result();

                if ($ipassetCheck->num_rows > 0) {
                    // If entry exists, update it with OR details
                    $updateIpAsset = $conn->prepare("UPDATE ipasset SET eORRefCode = ?, eORAddedBy = ? WHERE InventionDisclosureCode = ?");
                    $updateIpAsset->bind_param("sss", $referenceCode, $currentUser, $inventionDisclosureCode);
                    $updateIpAsset->execute();
                    $updateIpAsset->close();
                } else {
                    // Otherwise, insert a new entry in ipasset
                    $newIPAssetCode = generateRandomCode();
                    $insertIpAsset = $conn->prepare("INSERT INTO ipasset (IPAssetCode, InventionDisclosureCode, eORRefCode, eORAddedBy) VALUES (?, ?, ?, ?)");
                    $insertIpAsset->bind_param("ssss", $newIPAssetCode, $inventionDisclosureCode, $referenceCode, $currentUser);
                    $insertIpAsset->execute();
                    $insertIpAsset->close();
                }

                // Commit transaction
                $conn->commit();
                echo "<script>alert('File uploaded successfully!');</script>";
            } catch (Exception $e) {
                // Rollback on error
                $conn->rollback();
                echo "<script>alert('Error uploading file: " . $e->getMessage() . "');</script>";
            }
        }
    }
}
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
            <h2 class="text-2xl font-semibold text-blue-900 mb-6">Official Receipt</h2>

            <!-- Search Field with Suggestions -->
            <div class="mb-4 relative">
                <label class="block text-gray-700 font-semibold mb-2">Search for SOA Reference Code</label>
                <input type="text" id="search-input" placeholder="Type SOA Reference Code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300" autocomplete="off">
                <div id="suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
            </div>

            <!-- Form Fields -->
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
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
                    <input type="text" id="reference-code" name="ReferenceCode" required class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Date Received</label>
                    <input type="text" id="date-received" name="DateReceived" placeholder="MM/DD/YYYY" required class="date-picker w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Upload New OR</label>
                    <label class="flex items-center justify-center px-4 py-2 bg-green-500 text-white rounded-lg cursor-pointer hover:bg-green-600">
                        <span>Select File</span>
                        <input type="file" name="file" accept=".pdf" class="hidden" id="file-input">
                    </label>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" id="upload-btn" class="flex-1 bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600">Upload</button>
                    <button type="button" id="clear-btn" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400">Clear</button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('#date-received', {
                dateFormat: 'm/d/Y'
            });

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

            searchInput.addEventListener('input', function () {
                const referenceCode = this.value.trim();
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

            function fetchSuggestions(referenceCode) {
                suggestionsContainer.innerHTML = `<div class="px-4 py-2 text-gray-600">Loading...</div>`;
                suggestionsContainer.classList.remove('hidden');

                fetch(`or_search.php?referenceCode=${encodeURIComponent(referenceCode)}`)
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

            clearBtn.addEventListener('click', resetForm);

            document.addEventListener('click', function (event) {
                if (!event.target.closest('.relative')) {
                    hideSuggestions();
                }
            });
        });
    </script>
</body>
</html>