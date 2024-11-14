<?php
// formality_search.php

// Display all errors for debugging purposes (Disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../includes/db_connect.php';
header('Content-Type: application/json');

// Check if a search term is provided
if (isset($_GET['title'])) {
    $title = trim($_GET['title']);

    if ($title === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Empty search term.'
        ]);
        exit;
    }

    // Query to fetch data from `invention_disclosure` where `eor_number` matches the search term
    $stmt = $conn->prepare("SELECT id, title_of_invention AS title, employee_name AS inventor, eor_number AS reference_code FROM invention_disclosure WHERE LOWER(eor_number) LIKE LOWER(CONCAT('%', ?, '%')) ORDER BY eor_number ASC LIMIT 5");

    if ($stmt) {
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = [
                'id' => $row['id'],
                'title' => htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'),
                'inventor' => htmlspecialchars($row['inventor'], ENT_QUOTES, 'UTF-8'),
                'reference_code' => htmlspecialchars($row['reference_code'], ENT_QUOTES, 'UTF-8')
            ];
        }

        echo json_encode([
            'success' => true,
            'suggestions' => $suggestions
        ]);

        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database query failed.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No search term provided.'
    ]);
}
?>
