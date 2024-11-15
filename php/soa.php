<?php
// soa.php

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
    <title>Statement of Account</title>
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
            <div class="mb-4">
                <button onclick="goBack()" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                     </svg>
                        Back to Previous Page
                </button>
            </div>

            <h2 class="text-2xl font-semibold text-blue-900 mb-6">Statement of Account</h2>

            <!-- Search Field with Suggestions -->
            <div class="mb-4 relative">
                <label class="block text-gray-700 font-semibold mb-2">Search for Invention Title</label>
                <input type="text" id="search-input" placeholder="Type title of invention..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300" autocomplete="off">
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
                    <label class="block text-gray-700 font-semibold mb-2">SOA Reference Code</label>
                    <input type="text" id="reference-code" name="ReferenceCode" required class="w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Date Received</label>
                    <input type="text" id="date-received" name="DateReceived" placeholder="MM/DD/YYYY" required class="date-picker w-full px-4 py-2 rounded-lg bg-gray-100 border border-gray-300">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Upload New SOA</label>
                    <label for="file-input" class="block w-full bg-green-500 text-white text-center py-2 rounded-lg cursor-pointer hover:bg-green-600">Select File</label>
                    <input type="file" id="file-input" name="file" accept=".pdf" class="hidden" required>
                </div>

                <button type="submit" id="upload-btn" class="w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 mt-4">Upload</button>
                <button type="button" id="clear-btn" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-400 mt-2">Clear</button>
            </form>
                   <!-- Download/Delete SOA Section -->
                    <div class="mt-10">
                        <h2 class="text-2xl font-semibold text-blue-900 mb-4">Download or Delete SOA</h2>

                        <!-- Search by SOA Reference Code -->
                        <div class="mb-4 relative">
                            <label class="block text-gray-700 font-semibold mb-2">Search by SOA Reference Code</label>
                            <input type="text" id="search-soa-input" placeholder="Type SOA reference code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300" autocomplete="off">
                            <div id="soa-suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
                        </div>

                        <!-- Action buttons for download and delete -->
                        <div id="soa-actions" class="hidden space-x-4 mt-4">
                            <button id="download-soa-btn" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600">Download</button>
                            <button id="delete-soa-btn" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600">Delete</button>
                        </div>
                    </div>
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
            const fileInput = document.getElementById('file-input');
            const clearBtn = document.getElementById('clear-btn');

            let debounceTimeout = null;

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

            function showSuggestions(suggestions) {
                suggestionsContainer.innerHTML = '';

                suggestions.forEach(item => {
                    const div = document.createElement('div');
                    div.textContent = `${item.title} by ${item.inventor}`;
                    div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                    div.dataset.id = item.id;
                    div.dataset.inventor = item.inventor;
                    div.dataset.referenceCode = item.soa_reference_number;
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
                referenceCodeField.value = item.soa_reference_number;
                hideSuggestions();
            }

            function resetForm() {
                inventionIdField.value = '';
                inventorField.value = '';
                referenceCodeField.value = '';
                fileInput.value = '';
                document.querySelector('label[for="file-input"]').innerText = 'Select File';
            }

            clearBtn.addEventListener('click', resetForm);
        });

        


        document.addEventListener('DOMContentLoaded', function () {
    const downloadSoaBtn = document.getElementById('download-soa-btn');
    const deleteSoaBtn = document.getElementById('delete-soa-btn');
    const soaActions = document.getElementById('soa-actions');
    const searchSoaInput = document.getElementById('search-soa-input');
    const soaSuggestions = document.getElementById('soa-suggestions');
    let selectedSoaReference = '';

    // Event listener for search input to fetch SOA suggestions
    searchSoaInput.addEventListener('input', function () {
        const reference = this.value.trim();
        if (reference.length > 0) {
            fetch(`soa_search_download.php?query=${encodeURIComponent(reference)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displaySuggestions(data.suggestions);
                    } else {
                        hideSuggestions();
                    }
                })
                .catch(error => console.error('Error fetching SOA suggestions:', error));
        } else {
            hideSuggestions();
        }
    });

    // Function to display SOA suggestions
    function displaySuggestions(suggestions) {
        soaSuggestions.innerHTML = '';
        suggestions.forEach(item => {
            const div = document.createElement('div');
            div.textContent = item.reference_code;
            div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
            div.onclick = () => selectSoaReference(item.reference_code);
            soaSuggestions.appendChild(div);
        });
        soaSuggestions.classList.remove('hidden');
    }

    // Download SOA file based on the selected SOA reference code
    downloadSoaBtn.addEventListener('click', function () {
        if (selectedSoaReference) {
            window.location.href = `soa_search_download.php?reference=${encodeURIComponent(selectedSoaReference)}&action=download`;
        } else {
            alert("Please select an SOA to download.");
        }
    });

    // Delete SOA record and update related tables
    deleteSoaBtn.addEventListener('click', function () {
        if (selectedSoaReference && confirm("Are you sure you want to delete this SOA? This action cannot be undone.")) {
            fetch(`soa_search_download.php?reference=${encodeURIComponent(selectedSoaReference)}&action=delete`)
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        resetForm();
                    }
                })
                .catch(error => console.error('Error deleting SOA:', error));
        } else {
            alert("Please select an SOA to delete.");
        }
    });

    // Function to select an SOA reference
    function selectSoaReference(reference) {
        selectedSoaReference = reference;
        searchSoaInput.value = reference;
        soaActions.classList.remove('hidden');
        hideSuggestions();
    }

    // Function to hide suggestions
    function hideSuggestions() {
        soaSuggestions.classList.add('hidden');
    }

    // Function to reset form fields
    function resetForm() {
        selectedSoaReference = '';
        soaActions.classList.add('hidden');
        searchSoaInput.value = '';
        hideSuggestions();
    }
});


        
    </script>
    <script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>