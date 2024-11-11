<?php
// Display all errors (for debugging purposes)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Initialize upload message
$uploadMessage = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileType = $_POST['fileType'] ?? '';
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate file type (only PDFs allowed)
    if ($fileExtension === 'pdf') {
        // Read the file content as binary data
        $fileContent = file_get_contents($fileTmpPath);

        // Include your database connection
        include '../includes/db_connect.php';

        // Insert into the correct table based on fileType
        if ($fileType === 'soa') {
            $stmt = $conn->prepare("INSERT INTO statementofaccount (SOAReference, InventionDisclosureCode, IPOPHLReceivedDate, SOA) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $inventionDisclosureCode = 'ID123'; // Example value for InventionDisclosureCode
                $ipophlReceivedDate = '2023-01-01'; // Example date

                $null = NULL; // Used for binary data placeholder
                $stmt->bind_param("sssb", $fileName, $inventionDisclosureCode, $ipophlReceivedDate, $null);
                $stmt->send_long_data(3, $fileContent); // Sending binary data to the fourth parameter

                if ($stmt->execute()) {
                    $uploadMessage = "<p class='success'>SOA file uploaded successfully: $fileName</p>";
                } else {
                    $uploadMessage = "<p class='error'>Failed to upload SOA file: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                $uploadMessage = "<p class='error'>Prepare failed: (" . $conn->errno . ") " . $conn->error . "</p>";
            }

        } elseif ($fileType === 'or') {
            $stmt = $conn->prepare("INSERT INTO electronicor (eORNumber, InventionDisclosureCode, eORDate, eOR) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $inventionDisclosureCode = 'ID456'; // Example value for InventionDisclosureCode
                $eorDate = '2023-02-15'; // Example date

                $null = NULL;
                $stmt->bind_param("sssb", $fileName, $inventionDisclosureCode, $eorDate, $null);
                $stmt->send_long_data(3, $fileContent);

                if ($stmt->execute()) {
                    $uploadMessage = "<p class='success'>OR file uploaded successfully: $fileName</p>";
                } else {
                    $uploadMessage = "<p class='error'>Failed to upload OR file: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                $uploadMessage = "<p class='error'>Prepare failed: (" . $conn->errno . ") " . $conn->error . "</p>";
            }

        } elseif ($fileType === 'formality') {
            $stmt = $conn->prepare("INSERT INTO formalityreport (DocumentNumber, InventionDisclosureCode, ReceivedDate, Document) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $inventionDisclosureCode = 'ID789'; // Example value for InventionDisclosureCode
                $receivedDate = '2023-03-10'; // Example date

                $null = NULL;
                $stmt->bind_param("sssb", $fileName, $inventionDisclosureCode, $receivedDate, $null);
                $stmt->send_long_data(3, $fileContent);

                if ($stmt->execute()) {
                    $uploadMessage = "<p class='success'>Formality Report uploaded successfully: $fileName</p>";
                } else {
                    $uploadMessage = "<p class='error'>Failed to upload Formality Report: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                $uploadMessage = "<p class='error'>Prepare failed: (" . $conn->errno . ") " . $conn->error . "</p>";
            }
        } else {
            $uploadMessage = "<p class='error'>Invalid file type specified.</p>";
        }
    } else {
        $uploadMessage = "<p class='error'>Only PDF files are allowed.</p>";
    }
}
?>

<!-- Popup Container -->
<div class="popup-container" id="uploadPopup">
    <div class="container">
        <span class="close-btn" onclick="closeUploadModal()">×</span>

        <h2>Upload Document</h2>

        <!-- Feedback Message -->
        <?php if ($uploadMessage): ?>
            <div><?php echo $uploadMessage; ?></div>
        <?php endif; ?>

        <!-- Drag-and-Drop Area -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="fileType" value="<?php echo htmlspecialchars($fileType); ?>">
            <div id="drag-drop-area" class="drag-drop-area">
                <p>Drag and drop your PDF file here</p>
                <p>or</p>
                <label class="custom-file-btn">
                    Choose File
                    <input type="file" name="file" id="file-input" accept=".pdf" required>
                </label>
                <div id="file-status" class="file-status">No file selected</div>
            </div>
            <button type="submit" class="upload-btn">Upload PDF</button>
        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('file-input');
    const fileStatus = document.getElementById('file-status');
    const dragDropArea = document.getElementById('drag-drop-area');

    fileInput.addEventListener('change', () => {
        fileStatus.textContent = fileInput.files[0] ? `File ready to upload: ${fileInput.files[0].name}` : 'No file selected';
        if (fileInput.files[0]) {
            fileStatus.classList.add('ready');
        } else {
            fileStatus.classList.remove('ready');
        }
    });
</script>

<style>
    /* General styling as before */
</style>


<style>
    /* General Styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }
    .popup-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container {
        background-color: white;
        width: 400px;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        position: relative;
    }
    .container:before {
        content: '';
        width: 100%;
        height: 5px;
        background-color: #f0ad4e;
        border-radius: 8px 8px 0 0;
        position: absolute;
        top: 0;
        left: 0;
    }
    h2 {
        margin-bottom: 20px;
        color: #444;
    }
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #333;
        cursor: pointer;
        font-weight: bold;
        transition: color 0.3s ease;
    }
    .close-btn:hover {
        color: #f0ad4e;
    }
    .drag-drop-area {
        border: 2px dashed #ccc;
        padding: 20px;
        border-radius: 6px;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }
    .drag-drop-area.dragging {
        border-color: #f0ad4e;
        background-color: #fff3cd;
    }
    .drag-drop-area p {
        margin: 10px 0;
        color: #666;
    }
    .custom-file-btn {
        background-color: #333;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        border: none;
        transition: background-color 0.3s ease;
        position: relative;
    }
    .custom-file-btn input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .custom-file-btn:hover {
        background-color: #444;
    }
    .file-status {
        margin-top: 10px;
        font-size: 14px;
        color: #666;
        font-style: italic;
    }
    .file-status.ready {
        color: #28a745;
        font-weight: bold;
        font-style: normal;
    }
    .upload-btn {
        background-color: #f0ad4e;
        color: white;
        padding: 12px;
        width: 100%;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        margin-top: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .upload-btn:hover {
        background-color: #e0a437;
        transform: scale(1.05);
    }
    .success {
        color: #28a745;
        margin-top: 15px;
    }
    .error {
        color: #dc3545;
        margin-top: 15px;
    }
</style>