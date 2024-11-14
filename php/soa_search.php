<?php
// soa_search.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

header('Content-Type: application/json');

if (isset($_GET['title'])) {
    $title = trim($_GET['title']);

    if ($title === '') {
        echo json_encode(['success' => false, 'message' => 'Empty search term.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, title_of_invention AS title, employee_name AS inventor, soa_reference_number FROM invention_disclosure WHERE LOWER(title_of_invention) LIKE LOWER(CONCAT('%', ?, '%')) ORDER BY title_of_invention ASC LIMIT 5");

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
                'soa_reference_number' => htmlspecialchars($row['soa_reference_number'], ENT_QUOTES, 'UTF-8')
            ];
        }

        echo json_encode(['success' => true, 'suggestions' => $suggestions]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query failed.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No search term provided.']);
}
?>
