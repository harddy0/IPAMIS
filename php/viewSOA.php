<div?php
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
    <title>Manage SOA</title>
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
            <h2 class="text-2xl font-semibold text-blue-900 mb-6">Manage SOA</h2>

            <!-- Search Field with Suggestions -->
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

             <!-- The content box -->
             <div class="blue-box" style="background-color: #031c3e; width: 100%; height: 40px; border-top-left-radius: 3px; border-top-right-radius: 3px; display: flex; align-items: center; color: white; font-family: Arial, sans-serif; font-size: 14px;">
                <div style="flex: 1; text-align: center;">Invention Code</div>
                <div style="flex: 1; text-align: center;">Inventor</div>
                <div style="flex: 1; text-align: center;">SOA Code</div>
                <div style="flex: 1; text-align: center;">SOA File/Title</div>
                <div style="flex: 1; text-align: center;">Date Upload</div>
                <div style="flex: 1; text-align: center;"></div>
            </div>

            <div class="lightblue-box" style="background-color: #6c85a7; width: 100%; height: 60px; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; display: flex; align-items: center; color: white; font-family: Arial, sans-serif; font-size: 14px;">
    <div style="flex: 1; text-align: center;" id="invention-code"></div>
    <div style="flex: 1; text-align: center;" id="inventor"></div>
    <div style="flex: 1; text-align: center;" id="soa-code"></div>
    <div style="flex: 1; text-align: center;" id="soa-file-title"></div>
    <div style="flex: 1; text-align: center;" id="date-upload"></div>
    <div style="flex: 1; text-align: center;">
        <button onclick="deleteRecord()" style="background: none; border: none; color: white; cursor: pointer;">🗑️</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-soa-input');
        const suggestionsContainer = document.getElementById('soa-suggestions');
        const inventionCodeDiv = document.getElementById('invention-code');
        const inventorDiv = document.getElementById('inventor');
        const soaCodeDiv = document.getElementById('soa-code');
        const soaFileTitleDiv = document.getElementById('soa-file-title');
        const dateUploadDiv = document.getElementById('date-upload');

        let debounceTimeout = null;

        // Search input listener
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();
            clearTimeout(debounceTimeout);

            if (query.length > 0) {
                debounceTimeout = setTimeout(() => {
                    fetchSuggestions(query);
                }, 300);
            } else {
                hideSuggestions();
                clearDisplay();
            }
        });

        // Fetch suggestions from the server
        async function fetchSuggestions(query) {
            try {
                suggestionsContainer.innerHTML = `<div class="px-4 py-2 text-gray-600">Loading...</div>`;
                suggestionsContainer.classList.remove('hidden');

                const response = await fetch(`soa_search.php?query=${encodeURIComponent(query)}`);
                const data = await response.json();

                if (data.success) {
                    displaySuggestions(data.suggestions);
                } else {
                    showNoResults();
                }
            } catch (error) {
                console.error('Error fetching suggestions:', error);
                showNoResults();
            }
        }

        // Display suggestions
        function displaySuggestions(suggestions) {
            suggestionsContainer.innerHTML = '';

            suggestions.forEach((item) => {
                const div = document.createElement('div');
                div.textContent = `${item.title} by ${item.inventor}`;
                div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                div.onclick = () => fetchRecordData(item.id);
                suggestionsContainer.appendChild(div);
            });

            suggestionsContainer.classList.remove('hidden');
        }

        // Fetch and display record data
        async function fetchRecordData(id) {
            try {
                const response = await fetch(`soa_search.php?id=${id}`);
                const data = await response.json();

                if (data.success) {
                    displayData(data.record);
                } else {
                    alert('No data found for the selected record.');
                }
            } catch (error) {
                console.error('Error fetching record data:', error);
            } finally {
                hideSuggestions();
            }
        }

        // Display data in the lightblue-box
        function displayData(record) {
            inventionCodeDiv.textContent = record.invention_code || 'N/A';
            inventorDiv.textContent = record.inventor || 'N/A';
            soaCodeDiv.textContent = record.soa_code || 'N/A';
            soaFileTitleDiv.textContent = record.soa_file_title || 'N/A';
            dateUploadDiv.textContent = record.date_uploaded || 'N/A';
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

        // Clear the displayed data
        function clearDisplay() {
            inventionCodeDiv.textContent = '';
            inventorDiv.textContent = '';
            soaCodeDiv.textContent = '';
            soaFileTitleDiv.textContent = '';
            dateUploadDiv.textContent = '';
        }

        // Delete record function
        async function deleteRecord() {
            const inventionCode = inventionCodeDiv.textContent.trim();

            if (inventionCode && confirm('Are you sure you want to delete this record?')) {
                try {
                    const response = await fetch(`soa_delete.php?invention_code=${encodeURIComponent(inventionCode)}`);
                    const data = await response.json();

                    if (data.success) {
                        alert('Record deleted successfully.');
                        clearDisplay();
                    } else {
                        alert('Error deleting record.');
                    }
                } catch (error) {
                    console.error('Error deleting record:', error);
                }
            } else {
                alert('No record selected to delete.');
            }
        }
    });
</script>

        </div>

        <!-- Footer -->
        <?php include '../includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchSoaInput = document.getElementById('search-soa-input');
    const soaSuggestions = document.getElementById('soa-suggestions');
    const downloadSoaBtn = document.getElementById('download-soa-btn');
    const deleteSoaBtn = document.getElementById('delete-soa-btn');
    const soaActions = document.getElementById('soa-actions');
    let selectedSoaReference = '';

    // Event listener for search input
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

    // Display suggestions
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

    // Select an SOA reference
    function selectSoaReference(reference) {
        selectedSoaReference = reference;
        searchSoaInput.value = reference;
        soaActions.classList.remove('hidden');
        hideSuggestions();
    }

    // Hide suggestions
    function hideSuggestions() {
        soaSuggestions.classList.add('hidden');
    }

    // Download SOA file
    downloadSoaBtn.addEventListener('click', function () {
        if (selectedSoaReference) {
            window.location.href = `soa_search_download.php?reference=${encodeURIComponent(selectedSoaReference)}&action=download`;
        } else {
            alert('Please select an SOA to download.');
        }
    });

    // Delete SOA record
    deleteSoaBtn.addEventListener('click', function () {
        if (selectedSoaReference && confirm('Are you sure you want to delete this SOA? This action cannot be undone.')) {
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
            alert('Please select an SOA to delete.');
        }
    });

    // Reset form fields
    function resetForm() {
        selectedSoaReference = '';
        soaActions.classList.add('hidden');
        searchSoaInput.value = '';
        hideSuggestions();
    }
});
</script>

</body>
</html>
