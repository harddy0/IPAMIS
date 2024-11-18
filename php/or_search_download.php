<?php
// or_search_download.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';
header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $reference = $_GET['reference'] ?? '';

    if ($action === 'download' && !empty($reference)) {
        $stmt = $conn->prepare("SELECT eOR FROM electronicor WHERE eORNumber = ?");
        $stmt->bind_param("s", $reference);
        $stmt->execute();
        $stmt->bind_result($or);
        if ($stmt->fetch()) {
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename=\"$reference.pdf\"");
            echo $or;
        } else {
            echo json_encode(['success' => false, 'message' => 'File not found.']);
        }
        $stmt->close();
        exit;
    }

    if ($action === 'delete' && !empty($reference)) {
        $conn->begin_transaction();
        try {
            // Nullify reference in `ipasset` table
            $stmt1 = $conn->prepare("UPDATE ipasset SET eORRefCode = NULL WHERE eORRefCode = ?");
            $stmt1->bind_param("s", $reference);
            $stmt1->execute();
            $stmt1->close();

            // Nullify reference in `invention_disclosure` table
            $stmt2 = $conn->prepare("UPDATE invention_disclosure SET eor_number = NULL WHERE eor_number = ?");
            $stmt2->bind_param("s", $reference);
            $stmt2->execute();
            $stmt2->close();

            // Delete OR from `electronicor` table
            $stmt3 = $conn->prepare("DELETE FROM electronicor WHERE eORNumber = ?");
            $stmt3->bind_param("s", $reference);
            $stmt3->execute();
            $stmt3->close();

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'OR deleted successfully.']);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Error deleting OR: ' . $e->getMessage()]);
        }
        exit;
    }
}

// Handle suggestions for OR search
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $stmt = $conn->prepare("SELECT eORNumber as reference_code FROM electronicor WHERE eORNumber LIKE CONCAT('%', ?, '%') LIMIT 5");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();
    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = ['reference_code' => $row['reference_code']];
    }
    echo json_encode(['success' => true, 'suggestions' => $suggestions]);
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>