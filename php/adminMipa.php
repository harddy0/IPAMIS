<?php
// Display all errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';
session_start();

// Function to generate a random IPAssetCode (e.g., 12-character alphanumeric)
function generateRandomCode($length = 12) {
    return substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', ceil($length/62))), 1, $length);
}

// Get the logged-in user's name
$current_user = isset($_SESSION['FirstName']) ? $_SESSION['FirstName'] : 'Unknown User';

// Handle file deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['fileType']) && isset($_POST['fileName'])) {
    $fileType = $_POST['fileType'];
    $fileName = $_POST['fileName'];

    // Begin transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        switch ($fileType) {
            case 'soa':
                // Set reference to NULL in ipasset and invention_disclosure tables without deleting the row
                $update_ipasset = $conn->prepare("UPDATE ipasset SET SOARefCode = NULL, SOAAddedBy = NULL WHERE SOARefCode = ?");
                $update_ipasset->bind_param("s", $fileName);
                $update_ipasset->execute();
                $update_ipasset->close();

                $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET soa_reference_number = NULL WHERE soa_reference_number = ?");
                $update_disclosure->bind_param("s", $fileName);
                $update_disclosure->execute();
                $update_disclosure->close();

                // Delete from the statementofaccount table last
                $stmt = $conn->prepare("DELETE FROM statementofaccount WHERE SOAReference = ?");
                break;

            case 'or':
                // Set reference to NULL in ipasset and invention_disclosure tables without deleting the row
                $update_ipasset = $conn->prepare("UPDATE ipasset SET eORRefCode = NULL, eORAddedBy = NULL WHERE eORRefCode = ?");
                $update_ipasset->bind_param("s", $fileName);
                $update_ipasset->execute();
                $update_ipasset->close();

                $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET eor_number = NULL WHERE eor_number = ?");
                $update_disclosure->bind_param("s", $fileName);
                $update_disclosure->execute();
                $update_disclosure->close();

                // Delete from the electronicor table last
                $stmt = $conn->prepare("DELETE FROM electronicor WHERE eORNumber = ?");
                break;

            case 'formality':
                // Set reference to NULL in ipasset and invention_disclosure tables without deleting the row
                $update_ipasset = $conn->prepare("UPDATE ipasset SET FormalityRefCode = NULL, FormalityAddedBy = NULL WHERE FormalityRefCode = ?");
                $update_ipasset->bind_param("s", $fileName);
                $update_ipasset->execute();
                $update_ipasset->close();

                $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET document_number = NULL WHERE document_number = ?");
                $update_disclosure->bind_param("s", $fileName);
                $update_disclosure->execute();
                $update_disclosure->close();

                // Delete from the formalityreport table last
                $stmt = $conn->prepare("DELETE FROM formalityreport WHERE DocumentNumber = ?");
                break;

            default:
                throw new Exception("Invalid file type.");
        }

        $stmt->bind_param("s", $fileName);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        echo "";
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "Error deleting file: " . $e->getMessage();
    }
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_POST['fileType']) && isset($_POST['InventionDisclosureCode']) && isset($_POST['ReferenceCode']) && isset($_POST['DateReceived'])) {
    $fileType = $_POST['fileType'];
    $inventionDisclosureCode = $_POST['InventionDisclosureCode'];
    $referenceCode = $_POST['ReferenceCode'];
    $dateReceived = $_POST['DateReceived'];
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Function to validate date format (mm/dd/yyyy)
    function validateDate($dateReceived) {
        $dateObj = DateTime::createFromFormat('m/d/Y', $dateReceived);
        $errors = DateTime::getLastErrors();
        
        if ($dateObj === false || ($errors && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            // Invalid date format
            return [
                'isValid' => false,
                'message' => "Invalid date format. Please use mm/dd/yyyy."
            ];
        }
        
        // Return valid date in mm/dd/yyyy format
        return [
            'isValid' => true,
            'date' => $dateObj->format('m/d/Y')
        ];
    }

    // Validate the received date
    $dateValidation = validateDate($dateReceived);
    if (!$dateValidation['isValid']) {
        echo $dateValidation['message'];
        exit;
    }

    // Use the formatted date
    $dateReceived = $dateValidation['date'];

    // Check if the InventionDisclosureCode exists in the invention_disclosure table
    $check_stmt = $conn->prepare("SELECT id FROM invention_disclosure WHERE id = ?");
    $check_stmt->bind_param("s", $inventionDisclosureCode);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // InventionDisclosureCode exists, proceed with upload
        if ($fileExtension === 'pdf') {
            $fileContent = file_get_contents($fileTmpPath);

            // Begin transaction to ensure atomicity
            $conn->begin_transaction();

            try {
                // Check if an ipasset entry exists for this InventionDisclosureCode
                $ipasset_check = $conn->prepare("SELECT IPAssetCode FROM ipasset WHERE InventionDisclosureCode = ?");
                $ipasset_check->bind_param("s", $inventionDisclosureCode);
                $ipasset_check->execute();
                $ipasset_check->bind_result($existingIPAssetCode);
                $ipasset_check->fetch();
                $ipasset_check->close();

                if ($existingIPAssetCode) {
                    // Entry exists, perform UPDATEs
                    switch ($fileType) {
                        case 'soa':
                            // Insert into statementofaccount
                            $stmt = $conn->prepare("INSERT INTO statementofaccount (SOAReference, InventionDisclosureCode, IPOPHLReceivedDate, SOA) VALUES (?, ?, ?, ?)");
                            $null = NULL;
                            $stmt->bind_param("ssss", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                            $stmt->send_long_data(3, $fileContent);
                            $stmt->execute();
                            $stmt->close();

                            // Update ipasset
                            $update_ipasset = $conn->prepare("UPDATE ipasset SET SOARefCode = ?, SOAAddedBy = ? WHERE InventionDisclosureCode = ?");
                            $update_ipasset->bind_param("sss", $referenceCode, $current_user, $inventionDisclosureCode);
                            $update_ipasset->execute();
                            $update_ipasset->close();

                            // Update invention_disclosure
                            $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET soa_reference_number = ? WHERE id = ?");
                            $update_disclosure->bind_param("ss", $referenceCode, $inventionDisclosureCode);
                            $update_disclosure->execute();
                            $update_disclosure->close();
                            break;

                        case 'or':
                            // Insert into electronicor
                            $stmt = $conn->prepare("INSERT INTO electronicor (eORNumber, InventionDisclosureCode, eORDate, eOR) VALUES (?, ?, ?, ?)");
                            $null = NULL;
                            $stmt->bind_param("ssss", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                            $stmt->send_long_data(3, $fileContent);
                            $stmt->execute();
                            $stmt->close();

                            // Update ipasset
                            $update_ipasset = $conn->prepare("UPDATE ipasset SET eORRefCode = ?, eORAddedBy = ? WHERE InventionDisclosureCode = ?");
                            $update_ipasset->bind_param("sss", $referenceCode, $current_user, $inventionDisclosureCode);
                            $update_ipasset->execute();
                            $update_ipasset->close();

                            // Update invention_disclosure
                            $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET eor_number = ? WHERE id = ?");
                            $update_disclosure->bind_param("ss", $referenceCode, $inventionDisclosureCode);
                            $update_disclosure->execute();
                            $update_disclosure->close();
                            break;

                        case 'formality':
                            // Insert into formalityreport
                            $stmt = $conn->prepare("INSERT INTO formalityreport (DocumentNumber, InventionDisclosureCode, ReceivedDate, Document) VALUES (?, ?, ?, ?)");
                            $null = NULL;
                            $stmt->bind_param("ssss", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                            $stmt->send_long_data(3, $fileContent);
                            $stmt->execute();
                            $stmt->close();

                            // Update ipasset
                            $update_ipasset = $conn->prepare("UPDATE ipasset SET FormalityRefCode = ?, FormalityAddedBy = ? WHERE InventionDisclosureCode = ?");
                            $update_ipasset->bind_param("sss", $referenceCode, $current_user, $inventionDisclosureCode);
                            $update_ipasset->execute();
                            $update_ipasset->close();

                            // Update invention_disclosure
                            $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET document_number = ? WHERE id = ?");
                            $update_disclosure->bind_param("ss", $referenceCode, $inventionDisclosureCode);
                            $update_disclosure->execute();
                            $update_disclosure->close();
                            break;

                        default:
                            throw new Exception("Invalid file type.");
                    }
                } else {
                    // Entry does not exist, perform INSERT
                    $newIPAssetCode = generateRandomCode(); // Generate unique IPAssetCode

                    // Ensure the generated IPAssetCode is unique
                    $unique = false;
                    while (!$unique) {
                        $check_code = $conn->prepare("SELECT IPAssetCode FROM ipasset WHERE IPAssetCode = ?");
                        $check_code->bind_param("s", $newIPAssetCode);
                        $check_code->execute();
                        $check_code->store_result();
                        if ($check_code->num_rows == 0) {
                            $unique = true;
                        } else {
                            $newIPAssetCode = generateRandomCode(); // Regenerate if not unique
                        }
                        $check_code->close();
                    }

                    switch ($fileType) {
                        case 'soa':
                            // Insert into statementofaccount
                            $stmt = $conn->prepare("INSERT INTO statementofaccount (SOAReference, InventionDisclosureCode, IPOPHLReceivedDate, SOA) VALUES (?, ?, ?, ?)");
                            $null = NULL;
                            $stmt->bind_param("ssss", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                            $stmt->send_long_data(3, $fileContent);
                            $stmt->execute();
                            $stmt->close();

                            // Insert into ipasset
                            $insert_ipasset = $conn->prepare("INSERT INTO ipasset (IPAssetCode, InventionDisclosureCode, SOARefCode, SOAAddedBy) VALUES (?, ?, ?, ?)");
                            $insert_ipasset->bind_param("ssss", $newIPAssetCode, $inventionDisclosureCode, $referenceCode, $current_user);
                            $insert_ipasset->execute();
                            $insert_ipasset->close();

                            // Update invention_disclosure
                            $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET soa_reference_number = ? WHERE id = ?");
                            $update_disclosure->bind_param("ss", $referenceCode, $inventionDisclosureCode);
                            $update_disclosure->execute();
                            $update_disclosure->close();
                            break;

                        case 'or':
                            // Insert into electronicor
                            $stmt = $conn->prepare("INSERT INTO electronicor (eORNumber, InventionDisclosureCode, eORDate, eOR) VALUES (?, ?, ?, ?)");
                            $null = NULL;
                            $stmt->bind_param("ssss", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                            $stmt->send_long_data(3, $fileContent);
                            $stmt->execute();
                            $stmt->close();

                            // Insert into ipasset
                            $insert_ipasset = $conn->prepare("INSERT INTO ipasset (IPAssetCode, InventionDisclosureCode, eORRefCode, eORAddedBy) VALUES (?, ?, ?, ?)");
                            $insert_ipasset->bind_param("ssss", $newIPAssetCode, $inventionDisclosureCode, $referenceCode, $current_user);
                            $insert_ipasset->execute();
                            $insert_ipasset->close();

                            // Update invention_disclosure
                            $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET eor_number = ? WHERE id = ?");
                            $update_disclosure->bind_param("ss", $referenceCode, $inventionDisclosureCode);
                            $update_disclosure->execute();
                            $update_disclosure->close();
                            break;

                        case 'formality':
                            // Insert into formalityreport
                            $stmt = $conn->prepare("INSERT INTO formalityreport (DocumentNumber, InventionDisclosureCode, ReceivedDate, Document) VALUES (?, ?, ?, ?)");
                            $null = NULL;
                            $stmt->bind_param("ssss", $referenceCode, $inventionDisclosureCode, $dateReceived, $null);
                            $stmt->send_long_data(3, $fileContent);
                            $stmt->execute();
                            $stmt->close();

                            // Insert into ipasset
                            $insert_ipasset = $conn->prepare("INSERT INTO ipasset (IPAssetCode, InventionDisclosureCode, FormalityRefCode, FormalityAddedBy) VALUES (?, ?, ?, ?)");
                            $insert_ipasset->bind_param("ssss", $newIPAssetCode, $inventionDisclosureCode, $referenceCode, $current_user);
                            $insert_ipasset->execute();
                            $insert_ipasset->close();

                            // Update invention_disclosure
                            $update_disclosure = $conn->prepare("UPDATE invention_disclosure SET document_number = ? WHERE id = ?");
                            $update_disclosure->bind_param("ss", $referenceCode, $inventionDisclosureCode);
                            $update_disclosure->execute();
                            $update_disclosure->close();
                            break;

                        default:
                            throw new Exception("Invalid file type.");
                    }
                }

                // Commit the transaction
                $conn->commit();
                echo "";
            } catch (Exception $e) {
                // Rollback the transaction on error
                $conn->rollback();
                echo "Error uploading file: " . $e->getMessage();
            }
        } else {
            echo "Only PDF files are allowed.";
        }
    } else {
        echo "Invention Disclosure Code does not exist.";
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
    <!-- Include flatpickr CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this file?");
        }
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.date-picker', {
                dateFormat: 'm/d/Y'
            });
        });
    </script>
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
                                <!-- Download Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </a>
                            <form method="POST" onsubmit="return confirmDelete();">
                                <input type="hidden" name="fileType" value="soa">
                                <input type="hidden" name="fileName" value="<?php echo htmlspecialchars($soa_file['SOAReference']); ?>">
                                <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                    <!-- Delete Icon -->
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
                <label class="block text-gray-700">Invention Disclosure Code</label>
                <input type="text" name="InventionDisclosureCode" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
                <label class="block text-gray-700">Reference Code</label>
                <input type="text" name="ReferenceCode" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
                <label class="block text-gray-700">Date Received</label>
                <input type="text" name="DateReceived" required placeholder="mm/dd/yyyy" class="date-picker w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
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
                                <!-- Download Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </a>
                            <form method="POST" onsubmit="return confirmDelete();">
                                <input type="hidden" name="fileType" value="or">
                                <input type="hidden" name="fileName" value="<?php echo htmlspecialchars($or_file['eORNumber']); ?>">
                                <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                    <!-- Delete Icon -->
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
                <label class="block text-gray-700">Invention Disclosure Code</label>
                <input type="text" name="InventionDisclosureCode" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
                <label class="block text-gray-700">Reference Code</label>
                <input type="text" name="ReferenceCode" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
                <label class="block text-gray-700">Date Received</label>
                <input type="text" name="DateReceived" required placeholder="mm/dd/yyyy" class="date-picker w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
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
                                <!-- Download Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </a>
                            <form method="POST" onsubmit="return confirmDelete();">
                                <input type="hidden" name="fileType" value="formality">
                                <input type="hidden" name="fileName" value="<?php echo htmlspecialchars($formality_file['DocumentNumber']); ?>">
                                <button type="submit" name="delete" class="text-red-600 hover:text-red-800">
                                    <!-- Delete Icon -->
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
                <label class="block text-gray-700">Invention Disclosure Code</label>
                <input type="text" name="InventionDisclosureCode" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
                <label class="block text-gray-700">Reference Code</label>
                <input type="text" name="ReferenceCode" required class="w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
                <label class="block text-gray-700">Date Received</label>
                <input type="text" name="DateReceived" required placeholder="mm/dd/yyyy" class="date-picker w-full px-4 py-2 rounded-lg bg-gray-200 text-gray-900 mt-2 mb-4">
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