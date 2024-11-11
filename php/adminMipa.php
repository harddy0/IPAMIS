<?php
// Display all errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

// Handle file deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['fileType']) && isset($_POST['fileName'])) {
    $fileType = $_POST['fileType'];
    $fileName = $_POST['fileName'];

    switch ($fileType) {
        case 'soa':
            $stmt = $conn->prepare("DELETE FROM statementofaccount WHERE SOAReference = ?");
            break;
        case 'or':
            $stmt = $conn->prepare("DELETE FROM electronicor WHERE eORNumber = ?");
            break;
        case 'formality':
            $stmt = $conn->prepare("DELETE FROM formalityreport WHERE DocumentNumber = ?");
            break;
        default:
            echo "Invalid file type.";
            exit;
    }

    $stmt->bind_param("s", $fileName);
    $stmt->execute();
    $stmt->close();
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['fileType'])) {
    $fileType = $_POST['fileType'];
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileExtension === 'pdf') {
        $fileContent = file_get_contents($fileTmpPath);

        switch ($fileType) {
            case 'soa':
                $stmt = $conn->prepare("INSERT INTO statementofaccount (SOAReference, InventionDisclosureCode, IPOPHLReceivedDate, SOA) VALUES (?, ?, ?, ?)");
                $inventionDisclosureCode = 'ID123';
                $ipophlReceivedDate = '2023-01-01';
                $stmt->bind_param("sssb", $fileName, $inventionDisclosureCode, $ipophlReceivedDate, $null);
                $stmt->send_long_data(3, $fileContent);
                $stmt->execute();
                $stmt->close();
                break;
            case 'or':
                $stmt = $conn->prepare("INSERT INTO electronicor (eORNumber, InventionDisclosureCode, eORDate, eOR) VALUES (?, ?, ?, ?)");
                $inventionDisclosureCode = 'ID456';
                $eorDate = '2023-02-15';
                $stmt->bind_param("sssb", $fileName, $inventionDisclosureCode, $eorDate, $null);
                $stmt->send_long_data(3, $fileContent);
                $stmt->execute();
                $stmt->close();
                break;
            case 'formality':
                $stmt = $conn->prepare("INSERT INTO formalityreport (DocumentNumber, InventionDisclosureCode, ReceivedDate, Document) VALUES (?, ?, ?, ?)");
                $inventionDisclosureCode = 'ID789';
                $receivedDate = '2023-03-10';
                $stmt->bind_param("sssb", $fileName, $inventionDisclosureCode, $receivedDate, $null);
                $stmt->send_long_data(3, $fileContent);
                $stmt->execute();
                $stmt->close();
                break;
        }
    }
}

// Fetch files from the database
$soa_files = $conn->query("SELECT SOAReference, SOA FROM statementofaccount ORDER BY SOAReference DESC");
$or_files = $conn->query("SELECT eORNumber, eOR FROM electronicor ORDER BY eORNumber DESC");
$formality_files = $conn->query("SELECT DocumentNumber, Document FROM formalityreport ORDER BY DocumentNumber DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage IP Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminMpa.css">
    <link rel="stylesheet" href="../css/dashboard_staff.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        .file-list {
            max-height: 150px;
            overflow-y: auto;
            background-color: #f1f5f9;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #e2e8f0;
        }
        .custom-file-input {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px;
            background-color: #f1f5f9;
            border-radius: 5px;
            color: #4a5568;
        }
        .file-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body class="bg-gray-100">

<?php include '../includes/dashboard.php'; ?>
<?php include '../includes/header.php'; ?>

<div class="dashboard p-10">
    <h2 class="text-2xl font-semibold text-gray-700 mb-8">Manage IP Assets</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Statement of Account Column -->
        <div class="bg-white rounded-lg shadow-md p-5">
            <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">Statement Of Account</div>
            <div class="file-list mt-4 space-y-2">
                <?php while ($soa_file = $soa_files->fetch_assoc()): ?>
                    <div class="bg-blue-100 text-blue-600 p-2 rounded flex justify-between items-center">
                        <span><?php echo htmlspecialchars($soa_file['SOAReference']); ?></span>
                        <div class="file-actions">
                            <a href="data:application/pdf;base64,<?php echo base64_encode($soa_file['SOA']); ?>" download="<?php echo htmlspecialchars($soa_file['SOAReference']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </a>
                            <form method="POST">
                                <input type="hidden" name="fileType" value="soa">
                                <input type="hidden" name="fileName" value="<?php echo htmlspecialchars($soa_file['SOAReference']); ?>">
                                <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <form method="POST" enctype="multipart/form-data" class="mt-4">
                <input type="hidden" name="fileType" value="soa">
                <label class="block text-gray-700">Upload New SOA</label>
                <label class="custom-file-input block mt-2 mb-4 relative bg-gray-200 rounded-lg text-gray-700 flex items-center px-4 py-2">
                    <input type="file" name="file" class="hidden" accept=".pdf" onchange="this.nextElementSibling.innerText = this.files[0].name">
                    <span>No file chosen</span>
                </label>
                <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600">Upload SOA</button>
            </form>
        </div>

        <!-- OR Column -->
        <div class="bg-white rounded-lg shadow-md p-5">
            <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">OR</div>
            <div class="file-list mt-4 space-y-2">
                <?php while ($or_file = $or_files->fetch_assoc()): ?>
                    <div class="bg-blue-100 text-blue-600 p-2 rounded flex justify-between items-center">
                        <span><?php echo htmlspecialchars($or_file['eORNumber']); ?></span>
                        <div class="file-actions">
                            <a href="data:application/pdf;base64,<?php echo base64_encode($or_file['eOR']); ?>" download="<?php echo htmlspecialchars($or_file['eORNumber']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </a>
                            <form method="POST">
                                <input type="hidden" name="fileType" value="or">
                                <input type="hidden" name="fileName" value="<?php echo htmlspecialchars($or_file['eORNumber']); ?>">
                                <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <form method="POST" enctype="multipart/form-data" class="mt-4">
                <input type="hidden" name="fileType" value="or">
                <label class="block text-gray-700">Upload New OR</label>
                <label class="custom-file-input block mt-2 mb-4 relative bg-gray-200 rounded-lg text-gray-700 flex items-center px-4 py-2">
                    <input type="file" name="file" class="hidden" accept=".pdf" onchange="this.nextElementSibling.innerText = this.files[0].name">
                    <span>No file chosen</span>
                </label>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg font-bold hover:bg-blue-600">Upload OR</button>
            </form>
        </div>

        <!-- Formality Report Column -->
        <div class="bg-white rounded-lg shadow-md p-5">
            <div class="text-center bg-blue-900 text-white font-bold py-2 rounded">Formality Report</div>
            <div class="file-list mt-4 space-y-2">
                <?php while ($formality_file = $formality_files->fetch_assoc()): ?>
                    <div class="bg-blue-100 text-blue-600 p-2 rounded flex justify-between items-center">
                        <span><?php echo htmlspecialchars($formality_file['DocumentNumber']); ?></span>
                        <div class="file-actions">
                            <a href="data:application/pdf;base64,<?php echo base64_encode($formality_file['Document']); ?>" download="<?php echo htmlspecialchars($formality_file['DocumentNumber']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </a>
                            <form method="POST">
                                <input type="hidden" name="fileType" value="formality">
                                <input type="hidden" name="fileName" value="<?php echo htmlspecialchars($formality_file['DocumentNumber']); ?>">
                                <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <form method="POST" enctype="multipart/form-data" class="mt-4">
                <input type="hidden" name="fileType" value="formality">
                <label class="block text-gray-700">Upload New Formality Report</label>
                <label class="custom-file-input block mt-2 mb-4 relative bg-gray-200 rounded-lg text-gray-700 flex items-center px-4 py-2">
                    <input type="file" name="file" class="hidden" accept=".pdf" onchange="this.nextElementSibling.innerText = this.files[0].name">
                    <span>No file chosen</span>
                </label>
                <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-lg font-bold hover:bg-yellow-600">Upload Formality Report</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>