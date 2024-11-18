<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Formality Report</title>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="../images/ctulogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/adminVa.css">
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
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-blue-900 mb-6">Manage Formality Report</h2>

                <!-- Search Field with Suggestions -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-semibold mb-2">Search by Formality Report Reference Code</label>
                    <input type="text" id="search-input" placeholder="Enter Formality Report Reference Code..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300">
                    <div id="suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-b-lg mt-1 shadow-lg hidden z-10"></div>
                </div>

                <!-- Details -->
                <div id="formality-details" class="hidden space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold">Invention Disclosure Code:</label>
                        <input type="text" id="formality-invention-code" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-200" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold">Inventor:</label>
                        <input type="text" id="formality-inventor" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-200" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold">Date Added:</label>
                        <input type="text" id="formality-date-added" class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-200" readonly>
                    </div>
                </div>

                <!-- Download and Delete Buttons -->
                <div id="download-actions" class="hidden mt-4 space-x-4">
                    <button id="download-btn" class="bg-blue-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-600">Download</button>
                    <button id="delete-btn" class="bg-red-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-red-600">Delete</button>
                </div>
            </div>

            <!-- Footer -->
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const suggestionsContainer = document.getElementById('suggestions');
            const formalityDetails = document.getElementById('formality-details');
            const formalityInventionCode = document.getElementById('formality-invention-code');
            const formalityInventor = document.getElementById('formality-inventor');
            const formalityDateAdded = document.getElementById('formality-date-added');
            const downloadActions = document.getElementById('download-actions');
            let selectedReferenceCode = null;

            // Fetch suggestions for download and delete
            searchInput.addEventListener('input', function () {
                const referenceCode = this.value.trim();
                if (referenceCode.length > 0) {
                    fetchSuggestions(referenceCode);
                } else {
                    hideSuggestions();
                }
            });

            function fetchSuggestions(referenceCode) {
                suggestionsContainer.innerHTML = `<div class="px-4 py-2 text-gray-600">Loading...</div>`;
                suggestionsContainer.classList.remove('hidden');

                fetch(`formality_search_download.php?query=${encodeURIComponent(referenceCode)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuggestions(data.suggestions);
                        } else {
                            showNoResults();
                        }
                    })
                    .catch(() => showNoResults());
            }

            function showSuggestions(suggestions) {
                suggestionsContainer.innerHTML = '';
                suggestions.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                    div.textContent = `${item.reference_code} - ${item.inventor}`;
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
                searchInput.value = item.reference_code;
                selectedReferenceCode = item.reference_code;
                formalityInventionCode.value = item.invention_code;
                formalityInventor.value = item.inventor;
                formalityDateAdded.value = item.date_added;
                hideSuggestions();
                downloadActions.classList.remove('hidden');
                formalityDetails.classList.remove('hidden');
            }

            // Handle Download Button
            document.getElementById('download-btn').addEventListener('click', function () {
                if (selectedReferenceCode) {
                    window.location.href = `formality_search_download.php?download=${encodeURIComponent(selectedReferenceCode)}`;
                }
            });

            // Handle Delete Button
            document.getElementById('delete-btn').addEventListener('click', function () {
                if (selectedReferenceCode) {
                    fetch(`formality_search_download.php?delete=${encodeURIComponent(selectedReferenceCode)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Formality Report deleted successfully!');
                                searchInput.value = '';
                                downloadActions.classList.add('hidden');
                                formalityDetails.classList.add('hidden');
                                selectedReferenceCode = null;
                            } else {
                                alert('Error deleting Formality Report.');
                            }
                        })
                        .catch(() => alert('An error occurred while deleting the Formality Report.'));
                }
            });
        });
    </script>
</body>
</html>