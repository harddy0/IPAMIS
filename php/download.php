<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../includes/db_connect.php';

// Check if 'type' and 'name' parameters are set
if (isset($_GET['type']) && isset($_GET['name'])) {
    $type = $_GET['type'];
    $name = $_GET['name'];

    try {
        // Prepare the SQL statement based on the file type
        switch ($type) {
            case 'soa':
                $stmt = $conn->prepare("SELECT SOA, SOAReference FROM statementofaccount WHERE SOAReference = ?");
                break;
            case 'or':
                $stmt = $conn->prepare("SELECT eOR, eORNumber FROM electronicor WHERE eORNumber = ?");
                break;
            case 'formality':
                $stmt = $conn->prepare("SELECT Document, DocumentNumber FROM formalityreport WHERE DocumentNumber = ?");
                break;
            default:
                throw new Exception("Invalid file type specified.");
        }

        // Check if preparation was successful
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind the 'name' parameter
        $stmt->bind_param("s", $name);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        // Store the result
        $stmt->store_result();

        // Check if the file exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            switch ($type) {
                case 'soa':
                    $stmt->bind_result($fileData, $fileName);
                    break;
                case 'or':
                    $stmt->bind_result($fileData, $fileName);
                    break;
                case 'formality':
                    $stmt->bind_result($fileData, $fileName);
                    break;
            }
            $stmt->fetch();
            $stmt->close();

            // Set appropriate headers for file download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($fileName . '.pdf') . '"');
            header('Content-Length: ' . strlen($fileData));

            // Output the file data
            echo $fileData;
            exit;
        } else {
            throw new Exception("File not found.");
        }
    } catch (Exception $e) {
        // Handle any errors
        echo "Error downloading file: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Invalid request parameters.";
}
?>
