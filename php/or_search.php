<?php
// or_search.php

// Display all errors for debugging purposes (Disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../includes/db_connect.php';

// Start the session if needed
session_start();

// Set the response header to JSON
header('Content-Type: application/json');

// Check if the 'referenceCode' parameter is set
if (isset($_GET['referenceCode'])) {
    $referenceCode = trim($_GET['referenceCode']);

    // Check if the reference code is not empty
    if ($referenceCode === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Empty search term.'
        ]);
        exit;
    }

    // Prepare the SQL statement using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, soa_reference_number AS referenceCode, employee_name AS inventor FROM invention_disclosure WHERE soa_reference_number LIKE CONCAT('%', ?, '%') ORDER BY soa_reference_number ASC LIMIT 5");

    if ($stmt) {
        $stmt->bind_param("s", $referenceCode);
        $stmt->execute();
        $result = $stmt->get_result();

        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = [
                'id' => $row['id'],
                'referenceCode' => htmlspecialchars($row['referenceCode'], ENT_QUOTES, 'UTF-8'),
                'inventor' => htmlspecialchars($row['inventor'], ENT_QUOTES, 'UTF-8')
            ];
        }

        echo json_encode([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database query failed.'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No search term provided.'
    ]);
}
?>
